<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;
        session_name(Env::str('SESSION_NAME', 'myhr_session'));
        session_set_cookie_params([
            'lifetime' => 0, 'path' => '/',
            'secure'   => Env::bool('SESSION_SECURE'),
            'httponly' => true,
            'samesite' => Env::str('SESSION_SAMESITE', 'Lax'),
        ]);
        session_start();
        $lifetime = Env::int('SESSION_LIFETIME', 30) * 60;
        $now = time();
        if (isset($_SESSION['_last_activity']) && ($now - $_SESSION['_last_activity']) > $lifetime) {
            self::destroy(); session_start();
            Flash::error('Your session expired. Please sign in again.');
        }
        $_SESSION['_last_activity'] = $now;
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function get(string $k, mixed $d = null): mixed { return $_SESSION[$k] ?? $d; }
    public static function put(string $k, mixed $v): void { $_SESSION[$k] = $v; }
    public static function forget(string $k): void { unset($_SESSION[$k]); }
}