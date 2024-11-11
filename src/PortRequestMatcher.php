<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class PortRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var int
     */
    private $port;

    public function __construct(int $port)
    {
        $this->port = $port;
    }

    public function matches(RequestInterface $request): bool
    {
        return $request->getUri()->getPort() === $this->port;
    }
}
