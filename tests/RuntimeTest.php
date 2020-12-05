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

use function iterator_to_array;
use function pcntl_signal;
use function posix_getpid;
use function Safe\posix_kill;
use function Safe\sleep;
use function trigger_error;

use const SIGUSR1;
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

    /**
     * @test
     */
    public function error(): void
    {
        $runtime = new Runtime(LOCATION);
        $future  = $runtime->run(static function (): string {
            trigger_error('Error! Error! Error!');

            return 'yay';
        });

        self::assertInstanceOf(Future::class, $future);
        $outcome = $future->value();
        self::assertInstanceOf(Outcome::class, $outcome);
        self::assertSame('yay', $outcome->result());
        $errors = iterator_to_array($outcome->errors()); /** @phpstan-ignore-line */
        self::assertCount(1, $errors);
    }

    /**
     * @test
     */
    public function signal(): void
    {
        pcntl_signal(SIGUSR1, static function (): void {
        });
        $runtime = new Runtime(LOCATION);
        for ($i = 0; $i < 29; $i++) {
            $runtime->run(static function (): string {
                sleep(3);

                return 'yay';
            });
        }

        $future = $runtime->run(static function (): string {
            return 'yay';
        });

        sleep(1);

        for ($i = 0; $i < 6; $i++) {
            posix_kill(posix_getpid(), SIGUSR1);
        }

        self::assertInstanceOf(Future::class, $future);
        $outcome = $future->value();
        self::assertInstanceOf(Outcome::class, $outcome);
        self::assertSame('yay', $outcome->result());
        $signals = iterator_to_array($outcome->signals()); /** @phpstan-ignore-line */
        self::assertGreaterThanOrEqual(1, $signals);
        foreach ($signals as $signal) {
            self::assertSame(SIGUSR1, $signal->signal());
        }
    }
}
