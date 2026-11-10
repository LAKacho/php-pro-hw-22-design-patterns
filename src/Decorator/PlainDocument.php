<?php

declare(strict_types=1);

namespace DesignPatterns\Decorator;

final class PlainDocument implements Document
{
    public function __construct(private readonly string $title)
    {
    }

    public function title(): string
    {
        return $this->title;
    }
}
