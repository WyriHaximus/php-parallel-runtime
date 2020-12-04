<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

final class Outcome
{
    /** @var mixed */
    private $result;

    /**
     * @param mixed $result
     */
    public function withResult($result): Outcome
    {
        $clone         = clone $this;
        $clone->result = $result;

        return $clone;
    }

    /**
     * @return mixed
     */
    public function result()
    {
        return $this->result;
    }
}
