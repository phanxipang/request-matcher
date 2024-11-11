<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;

final class QueryParameterRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var array<array-key, string>
     */
    private $parameters;

    /**
     * @param  array<array-key, string> $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function matches(RequestInterface $request): bool
    {
        if (\count($this->parameters) === 0) {
            return false;
        }

        \parse_str($request->getUri()->getQuery(), $query);

        foreach ($this->parameters as $name => $value) {
            if (\is_numeric($name) && ! \array_key_exists($value, $query)) {
                return false;
            }

            if (\is_string($name) && ($query[$name] ?? null) !== $value) {
                return false;
            }
        }

        return true;
    }
}
