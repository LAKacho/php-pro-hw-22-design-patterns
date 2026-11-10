<?php

declare(strict_types=1);

namespace DesignPatterns\Strategy;

final class PerWordPricing implements PricingStrategy
{
    public function calculate(array $documents): int
    {
        return array_sum(array_map(
            static fn (Document $document): int => count($document->words()),
            $documents,
        ));
    }
}
