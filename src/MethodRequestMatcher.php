<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class MethodRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var string[]
     */
    private $methods = [];

    public function __construct(string ...$methods)
    {
        $this->methods = \array_map('strtoupper', $methods);
    }

    public function matches(RequestInterface $request): bool
    {
        return \in_array(\strtoupper($request->getMethod()), $this->methods, true);
    }
}
