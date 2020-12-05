<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

use function func_get_args;

use const WyriHaximus\Constants\Boolean\TRUE_;

final class ErrorCollector
{
    /** @var array<mixed> */
    private array $errors = [];

    public function getErrorHandler(): callable
    {
        return function (): bool {
            $this->errors[] = func_get_args();

            return TRUE_;
        };
    }

    /**
     * @return iterable<mixed>
     */
    public function errors(): iterable
    {
        yield from $this->errors;
    }
}
