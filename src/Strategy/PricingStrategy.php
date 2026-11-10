<?php

declare(strict_types=1);

namespace DesignPatterns\Strategy;

interface PricingStrategy
{
     
    public function calculate(array $documents): int;
}
