<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\HostRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class HostRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_host_request_matcher(string $pattern, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://foo.example.com');
        $matcher = new HostRequestMatcher($pattern);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            ['.*\.example\.com', true],
            ['\.example\.com$', true],
            ['^.*\.example\.com$', true],
            ['.*\.github\.com', false],
            ['.*\.example\.COM', true],
            ['\.example\.COM$', true],
            ['^.*\.example\.COM$', true],
            ['.*\.github\.COM', false],
        ];
    }
}
