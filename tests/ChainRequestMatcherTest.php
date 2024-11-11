<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\ChainRequestMatcher;
use Fansipan\RequestMatcher\HeaderRequestMatcher;
use Fansipan\RequestMatcher\HostRequestMatcher;
use Fansipan\RequestMatcher\PathRequestMatcher;
use Fansipan\RequestMatcher\QueryParameterRequestMatcher;
use Fansipan\RequestMatcher\SchemeRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class ChainRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_chain_request_matcher(iterable $matchers, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://localhost/hello?foo&bar=1');
        $matcher = new ChainRequestMatcher($matchers);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            [
                [
                    new HostRequestMatcher('localhost'),
                    new SchemeRequestMatcher('http'),
                    PathRequestMatcher::glob('/hello'),
                ],
                true,
            ],
            [
                [
                    new HostRequestMatcher('localhost'),
                    new SchemeRequestMatcher('http'),
                    new HeaderRequestMatcher(['foo']),
                ],
                false,
            ],
            [
                [
                    new HostRequestMatcher('localhost'),
                    new SchemeRequestMatcher('http'),
                    new QueryParameterRequestMatcher(['foo', 'bar']),
                ],
                true,
            ],
        ];
    }
}
