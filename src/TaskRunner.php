<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

use Closure;

use function restore_error_handler;
use function set_error_handler;

final class TaskRunner
{
    /**
     * @param array<mixed>|null $argv
     *
     * @phpstan-ignore-next-line
     */
    public static function run(Closure $task, ?array $argv = null): Outcome
    {
        $outcome        = new Outcome();
        $errorCollector = new ErrorCollector();

        set_error_handler($errorCollector->getErrorHandler());

        if ($argv === null) {
            $argv = [];
        }

        $outcome = $outcome->withResult($task(...$argv));
        foreach ($errorCollector->errors() as $error) {
            $outcome = $outcome->withError($error);
        }

        restore_error_handler();

        return $outcome;
    }
}
