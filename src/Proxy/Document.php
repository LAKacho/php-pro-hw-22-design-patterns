<?php

declare(strict_types=1);

namespace DesignPatterns\Proxy;

final class Document implements ReviewableDocument
{
     
    public function __construct(
        private readonly string $title,
        private readonly array $reviews,
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function reviews(): array
    {
        return $this->reviews;
    }
}
