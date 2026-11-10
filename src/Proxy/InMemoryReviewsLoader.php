<?php

declare(strict_types=1);

namespace DesignPatterns\Proxy;

final class InMemoryReviewsLoader implements ReviewsLoader
{
    private int $calls = 0;

     
    public function __construct(private readonly array $reviewsByDocument)
    {
    }

    public function load(int $documentId): array
    {
        $this->calls++;

        return $this->reviewsByDocument[$documentId] ?? [];
    }

    public function calls(): int
    {
        return $this->calls;
    }
}
