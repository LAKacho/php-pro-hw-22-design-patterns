<?php

declare(strict_types=1);

namespace DesignPatterns\ChainOfResponsibility;

abstract class AbstractRequestHandler implements RequestHandler
{
    private ?RequestHandler $next = null;

    final public function setNext(RequestHandler $next): RequestHandler
    {
        $this->next = $next;

        return $next;
    }

    final public function handle(Request $request): void
    {
        $this->check($request);
        $this->next?->handle($request);
    }

    abstract protected function check(Request $request): void;
}
