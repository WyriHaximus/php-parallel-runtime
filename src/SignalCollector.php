<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

final class SignalCollector
{
    /** @var array<Signal> */
    private array $signals = [];

    public function getSignalHandler(): callable
    {
        /**
         * @psalm-suppress MissingClosureParamType
         */
        return function (int $signal, $info): void {
            $this->signals[] = new Signal($signal, $info);
        };
    }

    /**
     * @return iterable<Signal>
     */
    public function signals(): iterable
    {
        yield from $this->signals;
    }
}
