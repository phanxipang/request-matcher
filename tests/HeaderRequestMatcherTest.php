<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\HeaderRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class HeaderRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_header_request_matcher(array $headers, array $expected, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://localhost');

        foreach ($headers as $key => $value) {
            $request = $request->withHeader($key, $value);
        }

        $matcher = new HeaderRequestMatcher($expected);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            'Exact match' => [
                [
                    'X-Foo' => 'foo',
                    'bar' => 'bar',
                ],
                [
                    'X-Foo' => 'foo',
                    'bar' => 'bar',
                ],
                true,
            ],
            'Header name existence' => [
                [
                    'X-Foo' => 'foo',
                ],
                [
                    'X-Foo',
                ],
                true,
            ],
            'Case insensitivity' => [
                [
                    'X-Foo' => 'foo',
                    'bar' => 'bar',
                ],
                [
                    'x-foo' => 'foo',
                    'BAR' => 'bar',
                ],
                true,
            ],
            'Only one header matching' => [
                [
                    'bar' => 'bar',
                ],
                [
                    'baz' => 'baz',
                    'bar' => 'bar',
                ],
                false,
            ],
            'Empty headers' => [
                [
                    'X-Foo' => 'foo',
                ],
                [],
                false,
            ],
        ];
    }
}
