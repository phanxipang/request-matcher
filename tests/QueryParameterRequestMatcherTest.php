<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\QueryParameterRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class QueryParameterRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_header_request_matcher(string $query, array $expected, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://localhost?'.$query);

        $matcher = new QueryParameterRequestMatcher($expected);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            [
                'foo=&bar=',
                [
                    'foo',
                    'bar',
                ],
                true,
            ],
            [
                'foo=foo1&bar=bar1',
                [
                    'foo' => 'foo1',
                    'bar' => 'bar1',
                ],
                true,
            ],
            [
                'foo=foo1&bar=bar1&baz=baz1',
                [
                    'foo',
                    'bar',
                    'baz' => 'baz1',
                ],
                true,
            ],
            [
                'foo=',
                ['bar'],
                false,
            ],
        ];
    }
}
