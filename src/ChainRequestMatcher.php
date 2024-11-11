<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class ChainRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var iterable<mixed, RequestMatcherInterface>
     */
    private $matchers;

    /**
     * @param iterable<RequestMatcherInterface> $matchers
     */
    public function __construct(iterable $matchers)
    {
        $this->matchers = $matchers;
    }

    public function matches(RequestInterface $request): bool
    {
        foreach ($this->matchers as $matcher) {
            if (! $matcher->matches($request)) {
                return false;
            }
        }

        return true;
    }
}
