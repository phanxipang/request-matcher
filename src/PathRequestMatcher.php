<?php

declare(strict_types=1);

namespace Fansipan\RequestMatcher;

use Psr\Http\Message\RequestInterface;
use Webmozart\Glob\Glob;

final class PathRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var bool
     */
    private $glob = false;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function matches(RequestInterface $request): bool
    {
        $path = rawurldecode($request->getUri()->getPath());

        if ($this->glob) {
            if (! \class_exists(Glob::class)) {
                throw new \LogicException('You cannot use the glob match as required dependency is not installed. Try running "composer require webmozart/glob".');
            }

            return Glob::match($path, $this->pattern);
        }

        return ! preg_match('{'.$this->pattern.'}', $path) ? false : true;
    }

    public static function glob(string $pattern): self
    {
        $self = new self($pattern);
        $self->glob = true;

        return $self;
    }
}
