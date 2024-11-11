<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class HostRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var string
     */
    private $regexp;

    public function __construct(string $regexp)
    {
        $this->regexp = $regexp;
    }

    public function matches(RequestInterface $request): bool
    {
        return ! preg_match('{'.$this->regexp.'}i', $request->getUri()->getHost()) ? false : true;
    }
}
