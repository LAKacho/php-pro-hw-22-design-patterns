<?php

declare(strict_types=1);

namespace DesignPatterns\Proxy;

interface ReviewableDocument
{
    public function title(): string;

     
    public function reviews(): array;
}
