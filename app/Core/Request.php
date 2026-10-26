<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Request
{
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array  $query,
        public readonly array  $post,
        public readonly array  $files,
        public readonly array  $server,
    ) {}

    public static function capture(): self
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
        if ($base !== '' && str_starts_with($path, $base)) $path = substr($path, strlen($base));
        $path = '/' . trim($path, '/');
        return new self(strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'), $path,
            $_GET, $_POST, $_FILES, $_SERVER);
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->query[$key] ?? $default;
    }

public function ipBinary(): string
{
    $bin = @inet_pton($this->ip());
    return $bin === false ? inet_pton('0.0.0.0') : $bin;
}

    public function str(string $key, string $default = ''): string
    {
        $v = $this->input($key, $default);
        return is_string($v) ? trim($v) : $default;
    }

    public function ip(): string { return $this->server['REMOTE_ADDR'] ?? '0.0.0.0'; }
    public function userAgent(): string { return substr($this->server['HTTP_USER_AGENT'] ?? '', 0, 255); }
    public function isPost(): bool { return $this->method === 'POST'; }
}