<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Rbac
{
    private static array $cache = [];

    public static function can(string $slug, ?int $userId = null): bool
    {
        if (Env::bool('APP_DEMO')) return true;
        $userId ??= Auth::id();
        if ($userId === null) return false;
        $perms = self::$cache[$userId] ?? self::load($userId);
        return isset($perms['*']) || isset($perms[$slug]);
    }

    private static function load(int $userId): array
    {
        $rows = Database::select(
            "SELECT DISTINCT p.slug FROM user_roles ur
                JOIN role_permissions rp ON rp.role_id = ur.role_id
                JOIN permissions p ON p.id = rp.permission_id
                JOIN roles r ON r.id = ur.role_id
               WHERE ur.user_id = ? AND r.status = 'active'", [$userId]);
        $map = [];
        foreach ($rows as $r) $map[$r['slug']] = true;
        $isSuper = (int) Database::scalar(
            "SELECT COUNT(*) FROM user_roles ur JOIN roles r ON r.id = ur.role_id
              WHERE ur.user_id = ? AND r.slug = 'super_admin'", [$userId]);
        if ($isSuper > 0) $map['*'] = true;
        return self::$cache[$userId] = $map;
    }
}