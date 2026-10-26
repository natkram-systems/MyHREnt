<?php
declare(strict_types=1);
namespace MyHR\Core;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $pdo = null;
    private static int $txDepth = 0;

    public static function boot(): void
    {
        if (self::$pdo !== null) return;
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
            Env::str('DB_HOST', '127.0.0.1'),
            Env::int('DB_PORT', 3306),
            Env::str('DB_DATABASE', 'myhr'),
            Env::str('DB_CHARSET', 'utf8mb4'));
        try {
            self::$pdo = new PDO($dsn, Env::str('DB_USERNAME'), Env::str('DB_PASSWORD'), [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            error_log('[MyHR] DB: ' . $e->getMessage());
            throw new RuntimeException('DATABASE_UNAVAILABLE');
        }
    }

    public static function pdo(): PDO
    {
        if (self::$pdo === null) throw new RuntimeException('DATABASE_NOT_BOOTED');
        return self::$pdo;
    }

    public static function select(string $sql, array $p = []): array
    {
        $st = self::pdo()->prepare($sql); $st->execute($p); return $st->fetchAll();
    }

    public static function first(string $sql, array $p = []): ?array
    {
        $st = self::pdo()->prepare($sql); $st->execute($p); $r = $st->fetch();
        return $r === false ? null : $r;
    }

    public static function scalar(string $sql, array $p = []): mixed
    {
        $st = self::pdo()->prepare($sql); $st->execute($p); return $st->fetchColumn();
    }

    public static function execute(string $sql, array $p = []): int
    {
        $st = self::pdo()->prepare($sql); $st->execute($p); return $st->rowCount();
    }

    public static function insert(string $sql, array $p = []): int
    {
        $st = self::pdo()->prepare($sql); $st->execute($p); return (int) self::pdo()->lastInsertId();
    }
}