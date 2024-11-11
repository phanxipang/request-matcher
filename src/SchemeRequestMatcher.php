<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class SchemeRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var string[]
     */
    private $schemes = [];

    public function __construct(string ...$schemes)
    {
        $this->schemes = \array_map('strtolower', $schemes);
    }

    public function matches(RequestInterface $request): bool
    {
        return \in_array($request->getUri()->getScheme(), $this->schemes, true);
    }
}
