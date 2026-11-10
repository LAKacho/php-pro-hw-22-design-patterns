<?php

declare(strict_types=1);

namespace DesignPatterns\Strategy;

final class LongWordPricing implements PricingStrategy
{
    public function __construct(
        private readonly int $minimumLength = 4,
        private readonly int $pricePerWord = 2,
    ) {
    }

    public function calculate(array $documents): int
    {
        $longWords = 0;

        foreach ($documents as $document) {
            foreach ($document->words() as $word) {
                if (mb_strlen($word) >= $this->minimumLength) {
                    $longWords++;
                }
            }
        }

        return $longWords * $this->pricePerWord;
    }
}
