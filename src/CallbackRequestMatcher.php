<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class CallbackRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var callable(RequestInterface): bool
     */
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function matches(RequestInterface $request): bool
    {
        return (bool) ($this->callback)($request);
    }
}
