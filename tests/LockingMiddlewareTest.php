<?php

declare(strict_types=1);

namespace Lamoda\TacticianLockingMiddlewareTest;

use Lamoda\TacticianLockingMiddleware\LockingMiddleware;
use PHPUnit\Framework\TestCase;

final class LockingMiddlewareTest extends TestCase
{
    /**
     * @var LockingMiddleware
     */
    private $middleware;

    protected function setUp(): void
    {
        $this->middleware = new LockingMiddleware();
    }

    public function testConsuming(): void
    {
        $command = new \stdClass();

        $wasCalled = false;
        $next = function ($givenCommand) use (&$wasCalled, $command) {
            $this->assertSame($command, $givenCommand);
            $wasCalled = true;

            return 'middleware result';
        };

        $result = $this->middleware->execute($command, $next);

        $this->assertTrue($wasCalled);
        $this->assertEquals('middleware result', $result);
    }

    public function testCommandsChaining(): void
    {
        $command1 = new \stdClass();
        $command2 = new \stdClass();

        $wasCalled1 = false;
        $wasCalled2 = false;

        $next2 = function ($givenCommand) use ($command2, &$wasCalled2) {
            $this->assertSame($command2, $givenCommand);
            $wasCalled2 = true;
        };

        $next1 = function ($givenCommand) use ($command1, $command2, $next2, &$wasCalled1, &$wasCalled2) {
            $this->assertSame($command1, $givenCommand);
            $wasCalled1 = true;

            // produce next command, but ensure that it is not executed until exit from the current command
            $this->middleware->execute($command2, $next2);
            $this->assertFalse($wasCalled2);
        };

        $this->middleware->execute($command1, $next1);

        $this->assertTrue($wasCalled1);
        $this->assertTrue($wasCalled2);
    }

    public function testThrowingOfExceptionDoesLockMiddlewareForever(): void
    {
        $command = new \stdClass();

        $next = static function () {
            throw new \TypeError('Something went wrong');
        };

        try {
            $this->middleware->execute($command, $next);
            $this->fail('Exception was expected to be thrown');
        } catch (\Throwable $e) {
            $this->assertInstanceOf(\TypeError::class, $e);
        }

        $wasCalled = false;
        $next = static function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $this->middleware->execute($command, $next);

        $this->assertTrue($wasCalled);
    }
}
