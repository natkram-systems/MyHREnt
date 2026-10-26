<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Audit
{
    public static function log(string $action, string $module, ?int $recordId = null,
        ?array $before = null, ?array $after = null, string $status = 'success', ?string $remarks = null): void
    {
        if (Env::bool('APP_DEMO')) return;
        try {
            Database::execute(
                "INSERT INTO audit_logs (organization_id, user_id, action, module, record_id,
                    before_values, after_values, status, remarks, ip_address, user_agent)
                 VALUES (?,?,?,?,?,?,?,?,?,?,?)",
                [Auth::orgId(), Auth::id(), $action, $module, $recordId,
                 $before ? json_encode($before) : null,
                 $after ? json_encode($after) : null,
                 $status, $remarks, $_SERVER['REMOTE_ADDR'] ?? null,
                 substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255)]);
        } catch (\Throwable $e) {
            error_log('[MyHR][AUDIT] ' . $e->getMessage());
        }
    }
}