<?php

declare(strict_types=1);

namespace DesignPatterns\Decorator;

final class InMemoryLogger implements Logger
{
     
    private array $messages = [];

    public function log(string $message): void
    {
        $this->messages[] = $message;
    }

     
    public function messages(): array
    {
        return $this->messages;
    }
}
