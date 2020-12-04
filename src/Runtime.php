<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

use Closure;
use parallel\Future;
use parallel\Runtime as ParallelRuntime;

use function func_get_args;

final class Runtime
{
    private ParallelRuntime $runtime;

    /**
     * @phpstan-ignore-next-line
     */
    public function __construct(?string $bootstrap = null)
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         */
        $this->runtime = new ParallelRuntime(...func_get_args());
    }

    /**
     * @param array<mixed>|null $argv
     *
     * @phpstan-ignore-next-line
     */
    public function run(Closure $task, ?array $argv = null): ?Future
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         */
        return $this->runtime->run(...func_get_args());
    }

    public function close(): void
    {
        $this->runtime->close();
    }

    public function kill(): void
    {
        $this->runtime->kill();
    }
}
