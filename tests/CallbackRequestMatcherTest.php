<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\CallbackRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

final class CallbackRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_callback_request_matcher(callable $callback, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://localhost');
        $matcher = new CallbackRequestMatcher($callback);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            [
                static function (RequestInterface $request) {
                    return true;
                },
                true,
            ],
            [
                static function (RequestInterface $request) {
                    return false;
                },
                false,
            ],
            [
                static function (RequestInterface $request) {
                    return $request->getUri()->getHost() === 'localhost';
                },
                true,
            ],
            [
                static function (RequestInterface $request) {
                    return $request->getUri()->getScheme() === 'https';
                },
                false,
            ],
        ];
    }
}
