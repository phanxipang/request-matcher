<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class HeaderRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var array<array-key, string>
     */
    private $headers;

    /**
     * @param  array<array-key, string> $headers
     */
    public function __construct(array $headers)
    {
        $this->headers = $headers;
    }

    public function matches(RequestInterface $request): bool
    {
        if (\count($this->headers) === 0) {
            return false;
        }

        foreach ($this->headers as $name => $value) {
            if (\is_numeric($name) && ! $request->hasHeader($value)) {
                return false;
            }

            if (\is_string($name) && $request->getHeaderLine($name) !== $value) {
                return false;
            }
        }

        return true;
    }
}
