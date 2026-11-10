<?php

declare(strict_types=1);

namespace DesignPatterns\Proxy;

final class LazyReviewsDocumentProxy implements ReviewableDocument
{
     
    private ?array $reviews = null;

    public function __construct(
        private readonly int $documentId,
        private readonly string $title,
        private readonly ReviewsLoader $loader,
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function reviews(): array
    {
        if ($this->reviews === null) {
            $this->reviews = $this->loader->load($this->documentId);
        }

        return $this->reviews;
    }
}
