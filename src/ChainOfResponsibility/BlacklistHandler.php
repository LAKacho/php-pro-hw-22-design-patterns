<?php

declare(strict_types=1);

namespace DesignPatterns\ChainOfResponsibility;

use DomainException;

final class BlacklistHandler extends AbstractRequestHandler
{
     
    public function __construct(private readonly array $blockedUsers)
    {
    }

    protected function check(Request $request): void
    {
        if (in_array($request->username, $this->blockedUsers, true)) {
            throw new DomainException('Пользователь заблокирован');
        }
    }
}
