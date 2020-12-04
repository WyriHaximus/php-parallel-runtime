<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use WyriHaximus\Parallel\Outcome;
use WyriHaximus\TestUtilities\TestCase;

use function iterator_to_array;

final class OutcomeTest extends TestCase
{
    /**
     * @test
     */
    public function result(): void
    {
        $outcome           = new Outcome();
        $outcomeWithResult = $outcome->withResult('resultaat');

        self::assertNotSame($outcome, $outcomeWithResult);
        self::assertSame('resultaat', $outcomeWithResult->result());
    }

    /**
     * @test
     */
    public function error(): void
    {
        $outcome          = new Outcome();
        $outcomeWithError = $outcome->withError(['ow noes!']);

        self::assertNotSame($outcome, $outcomeWithError);
        self::assertSame([['ow noes!']], iterator_to_array($outcomeWithError->errors())); /** @phpstan-ignore-line */
    }
}
