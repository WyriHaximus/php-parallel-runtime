<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use WyriHaximus\Parallel\Outcome;
use WyriHaximus\TestUtilities\TestCase;

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
}
