<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use WyriHaximus\Parallel\Error;
use WyriHaximus\Parallel\Outcome;
use WyriHaximus\Parallel\Signal;
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
        $error            = new Error(100, 'ow noes!', __FILE__, __LINE__);
        $outcome          = new Outcome();
        $outcomeWithError = $outcome->withError($error);

        self::assertNotSame($outcome, $outcomeWithError);
        self::assertSame([$error], iterator_to_array($outcomeWithError->errors())); /** @phpstan-ignore-line */
    }

    /**
     * @test
     */
    public function signal(): void
    {
        $signal            = new Signal(100, 'ow noes!');
        $outcome           = new Outcome();
        $outcomeWithSignal = $outcome->withSignal($signal);

        self::assertNotSame($outcome, $outcomeWithSignal);
        self::assertSame([$signal], iterator_to_array($outcomeWithSignal->signals())); /** @phpstan-ignore-line */
    }
}
