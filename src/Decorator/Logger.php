<?php

declare(strict_types=1);

namespace DesignPatterns\Decorator;

interface Logger
{
    public function log(string $message): void;
}
