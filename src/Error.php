<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

final class Error
{
    private int $level;
    private string $message;
    private string $file;
    private int $line;

    public function __construct(int $level, string $message, string $file, int $line)
    {
        $this->level   = $level;
        $this->message = $message;
        $this->file    = $file;
        $this->line    = $line;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function file(): string
    {
        return $this->file;
    }

    public function line(): int
    {
        return $this->line;
    }
}
