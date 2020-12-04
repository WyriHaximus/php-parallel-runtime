<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

use Closure;

final class TaskRunner
{
    /**
     * @param array<mixed>|null $argv
     *
     * @phpstan-ignore-next-line
     */
    public static function run(Closure $task, ?array $argv = null): Outcome
    {
        $outcome = new Outcome();
        if ($argv === null) {
            $argv = [];
        }

        $outcome = $outcome->withResult($task(...$argv));

        return $outcome;
    }
}
