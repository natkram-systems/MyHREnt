<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Validator
{
    private array $errors = [];
    public function __construct(private array $data) {}

    public function required(string $f, string $l): self
    {
        $v = $this->data[$f] ?? '';
        if (is_string($v) ? trim($v) === '' : empty($v)) $this->errors[$f][] = "$l is required.";
        return $this;
    }
    public function email(string $f, string $l): self
    {
        $v = (string) ($this->data[$f] ?? '');
        if ($v !== '' && !filter_var($v, FILTER_VALIDATE_EMAIL)) $this->errors[$f][] = "$l must be a valid email.";
        return $this;
    }
    public function minLen(string $f, int $min, string $l): self
    {
        $v = (string) ($this->data[$f] ?? '');
        if ($v !== '' && mb_strlen($v) < $min) $this->errors[$f][] = "$l must be at least $min characters.";
        return $this;
    }
    public function fails(): bool { return $this->errors !== []; }
    public function errors(): array { return $this->errors; }
    public function firstError(): string
    {
        foreach ($this->errors as $msgs) return $msgs[0];
        return '';
    }
}