<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\SchemeRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class SchemeRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_scheme_request_matcher(string $uri, $schemes, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', $uri);
        $matcher = \is_array($schemes) ? new SchemeRequestMatcher(...$schemes) : new SchemeRequestMatcher($schemes);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideData(): iterable
    {
        yield from [
            ['http://localhost', 'http', true],
            ['http://localhost', 'HTTP', true],
            ['https://foo.bar', 'https', true],
            ['http://127.0.0.1', 'ftp', false],
            ['http://127.0.0.1', ['ftp', 'http'], true],
            ['http://127.0.0.1', ['FTP', 'HTTP'], true],
            ['http://localhost', ['http', 'ftp'], true],
            ['http://localhost', ['http', 'ftp'], true],
        ];
    }
}
