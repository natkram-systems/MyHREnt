<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Csrf
{
    private const KEY = '_csrf_token';

    public static function token(): string
    {
        if (empty($_SESSION[self::KEY])) $_SESSION[self::KEY] = bin2hex(random_bytes(32));
        return $_SESSION[self::KEY];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_token" value="' . htmlspecialchars(self::token(), ENT_QUOTES) . '">';
    }

    public static function verify(?string $t): bool
    {
        $s = $_SESSION[self::KEY] ?? '';
        return is_string($t) && $s !== '' && hash_equals($s, $t);
    }

    public static function rotate(): void { unset($_SESSION[self::KEY]); }
}