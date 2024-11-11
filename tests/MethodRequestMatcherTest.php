<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\MethodRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class MethodRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_method_request_matcher(string $method, $methods, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest($method, 'http://localhost');
        $matcher = \is_array($methods) ? new MethodRequestMatcher(...$methods) : new MethodRequestMatcher($methods);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            ['get', 'get', true],
            ['get', ['post', 'get'], true],
            ['get', ['post', 'get'], true],
            ['get', ['post', 'GET'], true],
            ['get', ['get', 'post'], true],
            ['get', 'post', false],
            ['get', 'GET', true],
            ['get', ['GET', 'POST'], true],
            ['get', 'POST', false],
        ];
    }
}
