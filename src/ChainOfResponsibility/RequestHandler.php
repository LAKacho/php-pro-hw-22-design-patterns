<?php

declare(strict_types=1);

namespace DesignPatterns\ChainOfResponsibility;

interface RequestHandler
{
    public function setNext(RequestHandler $next): RequestHandler;

    public function handle(Request $request): void;
}
