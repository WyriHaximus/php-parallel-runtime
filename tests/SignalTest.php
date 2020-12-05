<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use WyriHaximus\Parallel\Signal;
use WyriHaximus\TestUtilities\TestCase;

final class SignalTest extends TestCase
{
    /**
     * @test
     */
    public function whatGoesInAlsoComesOut(): void
    {
        $signal = 666;
        $info   = '🤘';

        $error = new Signal($signal, $info);
        self::assertSame($signal, $error->signal());
        self::assertSame($info, $error->info());
    }
}
