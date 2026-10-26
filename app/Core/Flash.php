<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Flash
{
    public static function success(string $m): void { $_SESSION['_flash'][] = ['success', $m]; }
    public static function error(string $m): void   { $_SESSION['_flash'][] = ['danger',  $m]; }
    public static function warning(string $m): void { $_SESSION['_flash'][] = ['warning', $m]; }
    public static function info(string $m): void    { $_SESSION['_flash'][] = ['info',    $m]; }

    public static function pull(): array
    {
        $f = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
        return $f;
    }
}