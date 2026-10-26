<?php
declare(strict_types=1);

use MyHR\Core\{Auth, Rbac};

function app_url(string $path = ''): string
{
    $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
    return $base . '/' . ltrim($path, '/');
}

function e(mixed $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function can(string $permission): bool { return Rbac::can($permission); }
function current_user(): ?array { return Auth::user(); }

function old(string $key, string $default = ''): string
{
    return $_SESSION['_old'][$key] ?? $default;
}