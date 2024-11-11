<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher\Tests;

use Fansipan\RequestMatcher\PathRequestMatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

final class PathRequestMatcherTest extends TestCase
{
    /**
     * @dataProvider provideRegexData
     */
    public function test_path_request_matcher_with_regex(string $path, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://localhost/admin/foo');
        $matcher = new PathRequestMatcher($path);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideRegexData(): iterable
    {
        yield from [
            ['/admin/.*', true],
            ['/admin', true],
            ['^/admin/.*$', true],
            ['/blog/.*', false],
        ];
    }

    /**
     * @dataProvider provideGlobData
     */
    public function test_path_request_matcher_with_glob(string $path, bool $matches): void
    {
        $request = (new Psr17Factory())->createRequest('GET', 'http://localhost/admin/foo');
        $matcher = PathRequestMatcher::glob($path);

        $this->assertSame($matcher->matches($request), $matches);
    }

    public static function provideGlobData(): iterable
    {
        yield from [
            ['/admin/*', true],
            ['/admin', false],
            ['/**/foo', true],
            ['/blog/*', false],
        ];
    }
}
