<?php

declare(strict_types=1);

namespace DesignPatterns\ChainOfResponsibility;

use DomainException;

final class AntispamHandler extends AbstractRequestHandler
{
     
    public function __construct(private readonly array $blockedIps)
    {
    }

    protected function check(Request $request): void
    {
        if (in_array($request->ip, $this->blockedIps, true)) {
            throw new DomainException('Доступ запрещён по IP');
        }
    }
}
