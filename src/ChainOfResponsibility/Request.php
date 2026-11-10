<?php

declare(strict_types=1);

namespace DesignPatterns\ChainOfResponsibility;

final class Request
{
    public function __construct(
        public readonly string $username,
        public readonly string $ip,
    ) {
    }
}
