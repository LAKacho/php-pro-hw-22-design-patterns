<?php

declare(strict_types=1);

namespace DesignPatterns\Strategy;

final class DocumentPricingService
{
    public function __construct(private readonly PricingStrategy $strategy)
    {
    }

     
    public function totalFor(array $documents): int
    {
        return $this->strategy->calculate($documents);
    }
}
