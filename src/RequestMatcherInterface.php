<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

interface RequestMatcherInterface
{
    /**
     * Decides whether the rule(s) implemented by the strategy matches the supplied request.
     */
    public function matches(RequestInterface $request): bool;
}
