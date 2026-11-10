<?php

declare(strict_types=1);

namespace DesignPatterns\Proxy;

interface ReviewsLoader
{
     
    public function load(int $documentId): array;
}
