<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use parallel\Future;
use parallel\Runtime\Error\Closed;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\Parallel\Runtime;

use function Safe\sleep;

final class RuntimeTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function success(): void
    {
        $runtime = new Runtime();
        $future  = $runtime->run(static function (): string {
            return 'yay';
        });

        sleep(1);

        self::assertInstanceOf(Future::class, $future);
        self::assertSame('yay', $future->value());
    }

    /**
     * @test
     */
    public function close(): void
    {
        self::expectException(Closed::class);

        $runtime = new Runtime();
        $runtime->close();
        $runtime->run(static function (): string {
            return 'yay';
        });
    }

    /**
     * @test
     */
    public function killed(): void
    {
        self::expectException(Closed::class);

        $runtime = new Runtime();
        $runtime->kill();
        $runtime->run(static function (): string {
            return 'yay';
        });
    }
}
