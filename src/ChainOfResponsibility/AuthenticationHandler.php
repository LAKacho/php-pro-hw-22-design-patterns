<?php

declare(strict_types=1);

namespace DesignPatterns\ChainOfResponsibility;

use DomainException;

final class AuthenticationHandler extends AbstractRequestHandler
{
    protected function check(Request $request): void
    {
        if (trim($request->username) === '') {
            throw new DomainException('Пользователь не аутентифицирован');
        }
    }
}
