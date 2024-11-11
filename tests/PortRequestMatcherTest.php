<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\PortRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class PortRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_port_request_matcher(int $port, $expected, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://localhost:'.$port);
        $matcher = new PortRequestMatcher($expected);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            [8080, 8080, true],
            [9000, 8080, false],
        ];
    }
}
