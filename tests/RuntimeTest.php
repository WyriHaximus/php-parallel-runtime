<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Parallel;

use Exception;
use parallel\Future;
use parallel\Runtime\Error\Closed;
use Throwable;
use TypeError;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\Parallel\Outcome;
use WyriHaximus\Parallel\Runtime;

use function Safe\sleep;

use const WyriHaximus\Constants\ComposerAutoloader\LOCATION;

final class RuntimeTest extends AsyncTestCase
{
    /**
     * @test
     */
    public function success(): void
    {
        $runtime = new Runtime(LOCATION);
        $future  = $runtime->run(static function (): string {
            return 'yay';
        });

        sleep(1);

        self::assertInstanceOf(Future::class, $future);
        $outcome = $future->value();
        self::assertInstanceOf(Outcome::class, $outcome);
        self::assertSame('yay', $outcome->result());
    }

    /**
     * @test
     */
    public function close(): void
    {
        self::expectException(Closed::class);

        $runtime = new Runtime(LOCATION);
        $runtime->close();
        $runtime->run(static function (): string {
            return 'yay';
        });
    }

    /**
     * @test
     */
    public function kill(): void
    {
        self::expectException(Closed::class);

        $runtime = new Runtime(LOCATION);
        $runtime->kill();
        $runtime->run(static function (): string {
            return 'yay';
        });
    }

    /**
     * @test
     */
    public function thrownException(): void
    {
        self::expectException(Throwable::class);
        self::expectExceptionMessage('nay');

        $runtime = new Runtime(LOCATION);
        $future  = $runtime->run(static function (): void {
            /** @phpstan-ignore-next-line */
            throw new Exception('nay');
        });

        self::assertInstanceOf(Future::class, $future);
        $future->value();
    }

    /**
     * @test
     */
    public function thrownError(): void
    {
        self::expectException(TypeError::class);
        self::expectExceptionMessageMatches('#string, int returned#');

        $runtime = new Runtime(LOCATION);
        $future  = $runtime->run(static function (): string {
            /** @phpstan-ignore-next-line */
            return 1;
        });

        self::assertInstanceOf(Future::class, $future);
        $future->value();
    }
}
