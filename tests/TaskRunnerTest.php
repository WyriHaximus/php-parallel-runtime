<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use WyriHaximus\Parallel\TaskRunner;
use WyriHaximus\TestUtilities\TestCase;

use function iterator_to_array;
use function trigger_error;

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

    /**
     * @test
     */
    public function error(): void
    {
        $outcome = TaskRunner::run(static fn (string $element): bool => trigger_error($element), ['fire']);
        self::assertTrue($outcome->result());
        $errors = iterator_to_array($outcome->errors()); /** @phpstan-ignore-line */
        self::assertCount(1, $errors);
        self::assertSame('fire', $errors[0]->message());
    }
}
