<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

use const WyriHaximus\Constants\Boolean\TRUE_;

final class ErrorCollector
{
    /** @var array<Error> */
    private array $errors = [];

    public function getErrorHandler(): callable
    {
        return function (int $level, string $message, string $file, int $line): bool {
            $this->errors[] = new Error($level, $message, $file, $line);

            return TRUE_;
        };
    }

    /**
     * @return iterable<Error>
     */
    public function errors(): iterable
    {
        yield from $this->errors;
    }
}
