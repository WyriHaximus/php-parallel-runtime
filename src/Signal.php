<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

final class Signal
{
    private int $signal;
    /** @var mixed */
    private $info;

    /**
     * @param mixed $info
     */
    public function __construct(int $signal, $info)
    {
        $this->signal = $signal;
        $this->info   = $info;
    }

    public function signal(): int
    {
        return $this->signal;
    }

    /**
     * @return mixed
     */
    public function info()
    {
        return $this->info;
    }
}
