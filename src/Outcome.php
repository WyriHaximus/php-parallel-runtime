<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

final class Outcome
{
    /** @var mixed */
    private $result;

    /** @var array<mixed> */
    private array $errors = [];

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

    /**
     * @param array<mixed> $error
     */
    public function withError(array $error): Outcome
    {
        $clone           = clone $this;
        $clone->errors[] = $error;

        return $clone;
    }

    /**
     * @return iterable<mixed>
     */
    public function errors(): iterable
    {
        yield from $this->errors;
    }
}
