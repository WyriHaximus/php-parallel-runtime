<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use WyriHaximus\Parallel\Error;
use WyriHaximus\TestUtilities\TestCase;

final class ErrorTest extends TestCase
{
    /**
     * @test
     */
    public function whatGoesInAlsoComesOut(): void
    {
        $level   = 666;
        $message = '🤘';
        $file    = __FILE__;
        $line    = __LINE__;

        $error = new Error($level, $message, $file, $line);
        self::assertSame($level, $error->level());
        self::assertSame($message, $error->message());
        self::assertSame($file, $error->file());
        self::assertSame($line, $error->line());
    }
}
