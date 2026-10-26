<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Env
{
    public static function load(string $root): void
    {
        \Dotenv\Dotenv::createImmutable($root)->safeLoad();
        date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Manila');
    }

    public static function bool(string $key, bool $default = false): bool
    {
        return filter_var($_ENV[$key] ?? $default, FILTER_VALIDATE_BOOL);
    }

    public static function str(string $key, string $default = ''): string
    {
        return (string) ($_ENV[$key] ?? $default);
    }

    public static function int(string $key, int $default = 0): int
    {
        return (int) ($_ENV[$key] ?? $default);
    }
}