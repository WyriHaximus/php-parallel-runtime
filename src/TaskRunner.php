<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

use Closure;

use function pcntl_async_signals;
use function pcntl_signal;
use function restore_error_handler;
use function set_error_handler;

use const SIGINT;
use const SIGTERM;
use const SIGUSR1;

final class TaskRunner
{
    private const SIGNALS = [SIGINT, SIGTERM, SIGUSR1];

    /**
     * @param array<mixed>|null $argv
     *
     * @phpstan-ignore-next-line
     */
    public static function run(Closure $task, ?array $argv = null): Outcome
    {
        $outcome         = new Outcome();
        $errorCollector  = new ErrorCollector();
        $signalCollector = new SignalCollector();
        $signalHandler   = $signalCollector->getSignalHandler();

        set_error_handler($errorCollector->getErrorHandler());

        pcntl_async_signals(true);
        foreach (self::SIGNALS as $signal) {
            pcntl_signal($signal, $signalHandler);
        }

        if ($argv === null) {
            $argv = [];
        }

        $outcome = $outcome->withResult($task(...$argv));
        foreach ($errorCollector->errors() as $error) {
            $outcome = $outcome->withError($error);
        }

        foreach ($signalCollector->signals() as $signal) {
            $outcome = $outcome->withSignal($signal);
        }

        restore_error_handler();
        foreach (self::SIGNALS as $signal) {
            pcntl_signal($signal, static function (): void {
            });
        }

        return $outcome;
    }
}
