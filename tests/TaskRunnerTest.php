<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use WyriHaximus\Parallel\TaskRunner;
use WyriHaximus\TestUtilities\TestCase;

final class TaskRunnerTest extends TestCase
{
    /**
     * @test
     */
    public function noArguments(): void
    {
        $outcome = TaskRunner::run(static fn (): string => 'earth');
        self::assertSame('earth', $outcome->result());
    }

    /**
     * @test
     */
    public function arguments(): void
    {
        $outcome = TaskRunner::run(static fn (string $element): string => $element, ['wind']);
        self::assertSame('wind', $outcome->result());
    }
}
