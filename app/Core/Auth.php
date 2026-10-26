<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Auth
{
    private static ?array $user = null;

    public static function user(): ?array
    {
        if (Env::bool('APP_DEMO')) {
            if (self::$user === null) self::$user = \MyHR\Support\DemoData::user();
            return self::$user;
        }
        if (self::$user !== null) return self::$user;
        $id = Session::get('_auth_user_id');
        if (!$id) return null;
        self::$user = Database::first(
            "SELECT u.id, u.organization_id, u.email, u.display_name, u.status,
                    u.must_change_password, o.name AS org_name, o.timezone
               FROM users u
               JOIN organizations o ON o.id = u.organization_id
              WHERE u.id = ? AND u.status = 'active'",
            [$id]
        );
        return self::$user;
    }

    public static function id(): ?int
    {
        return self::user() ? (int) self::user()['id'] : null;
    }

    public static function orgId(): ?int
    {
        return self::user() ? (int) self::user()['organization_id'] : null;
    }

    public static function check(): bool { return self::user() !== null; }

    /**
     * @return array{ok:bool, reason?:string}
     */
    public static function attempt(string $email, string $password, Request $req): array
    {
        $email = mb_strtolower(trim($email));
        $maxAttempts = Env::int('LOGIN_MAX_ATTEMPTS', 5);
        $lockMinutes = Env::int('LOGIN_LOCKOUT_MINUTES', 15);
        $window = 15;

        // Throttle: 5 failed in last 15 minutes for this email OR this IP.
        $recent = (int) Database::scalar(
            "SELECT COUNT(*) FROM login_attempts
              WHERE successful = 0
                AND attempted_at > (NOW() - INTERVAL ? MINUTE)
                AND (email = ? OR ip_address = ?)",
            [$window, $email, $req->ipBinary()]
        );
        if ($recent >= $maxAttempts) {
            self::recordAttempt($email, $req, false);
            Audit::log('auth.login_throttled', 'auth', null, null, null, 'blocked', $email);
            return ['ok' => false, 'reason' => 'Too many failed attempts. Try again in ' . $lockMinutes . ' minutes.'];
        }

        $user = Database::first(
            "SELECT id, organization_id, password_hash, status, locked_until
               FROM users WHERE email = ?",
            [$email]
        );
        if (!$user) {
            self::recordAttempt($email, $req, false);
            return ['ok' => false, 'reason' => 'Invalid email or password.'];
        }
        if ($user['status'] !== 'active') {
            self::recordAttempt($email, $req, false);
            return ['ok' => false, 'reason' => 'Account is not active. Contact your administrator.'];
        }
        if ($user['locked_until'] !== null && strtotime($user['locked_until']) > time()) {
            self::recordAttempt($email, $req, false);
            return ['ok' => false, 'reason' => 'Account temporarily locked. Try again later.'];
        }
        if (!password_verify($password, $user['password_hash'])) {
            self::recordAttempt($email, $req, false);
            $fails = (int) Database::scalar(
                "SELECT COUNT(*) FROM login_attempts
                  WHERE successful = 0 AND email = ?
                    AND attempted_at > (NOW() - INTERVAL ? MINUTE)",
                [$email, $window]
            );
            if ($fails >= $maxAttempts) {
                Database::execute(
                    "UPDATE users SET locked_until = DATE_ADD(NOW(), INTERVAL ? MINUTE) WHERE id = ?",
                    [$lockMinutes, $user['id']]
                );
                Audit::log('auth.account_locked', 'auth', (int) $user['id'], null, null, 'success');
            }
            return ['ok' => false, 'reason' => 'Invalid email or password.'];
        }

        if (password_needs_rehash($user['password_hash'], PASSWORD_ARGON2ID)) {
            Database::execute(
                "UPDATE users SET password_hash = ? WHERE id = ?",
                [password_hash($password, PASSWORD_ARGON2ID), $user['id']]
            );
        }

        self::recordAttempt($email, $req, true);
        self::login((int) $user['id'], $req);
        return ['ok' => true];
    }

    public static function login(int $userId, Request $req): void
    {
        session_regenerate_id(true);
        Csrf::rotate();
        Database::execute(
            "UPDATE users SET last_login_at = NOW(), last_login_ip = ?, failed_login_count = 0, locked_until = NULL WHERE id = ?",
            [$req->ipBinary(), $userId]
        );
        Session::put('_auth_user_id', $userId);
        Session::put('_last_activity', time());
        self::$user = null;
        Audit::log('auth.login', 'auth', $userId, null, null, 'success');
    }

    public static function logout(): void
    {
        if ($id = self::id()) Audit::log('auth.logout', 'auth', $id, null, null, 'success');
        self::$user = null;
        Session::destroy();
    }

    private static function recordAttempt(string $email, Request $req, bool $ok): void
    {
        Database::execute(
            "INSERT INTO login_attempts (email, ip_address, user_agent, successful)
             VALUES (?, ?, ?, ?)",
            [$email, $req->ipBinary(), $req->userAgent(), $ok ? 1 : 0]
        );
    }
}