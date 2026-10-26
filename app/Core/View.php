<?php
declare(strict_types=1);
namespace MyHR\Core;

final class View
{
    public static function render(string $tpl, array $data = [], ?string $layout = 'layouts/app'): string
    {
        $data['auth']  = Auth::user();
        $data['flash'] = Flash::pull();
        $data['demo']  = Env::bool('APP_DEMO');
        $content = self::capture($tpl, $data);
        if ($layout === null) return $content;
        return self::capture($layout, $data + ['content' => $content]);
    }

    private static function capture(string $tpl, array $data): string
    {
        $file = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $tpl) . '.php';
        if (!is_file($file)) throw new \RuntimeException("View not found: $tpl");
        extract($data, EXTR_SKIP);
        ob_start();
        try { require $file; }
        catch (\Throwable $e) { ob_end_clean(); throw $e; }
        return (string) ob_get_clean();
    }
}