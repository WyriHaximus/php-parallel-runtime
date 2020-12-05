<?php

declare(strict_types=1);

namespace WyriHaximus\Parallel;

final class Outcome
{
    /** @var mixed */
    private $result;

    /** @var array<Error> */
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

    public function withError(Error $error): Outcome
    {
        $clone           = clone $this;
        $clone->errors[] = $error;

        return $clone;
    }

    /**
     * @return iterable<Error>
     */
    public function errors(): iterable
    {
        yield from $this->errors;
    }
}
