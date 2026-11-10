<?php

declare(strict_types=1);

namespace DesignPatterns\Strategy;

final class Document
{
    public function __construct(public readonly string $title)
    {
    }

     
    public function words(): array
    {
        $words = preg_split('/\s+/u', trim($this->title), -1, PREG_SPLIT_NO_EMPTY);

        return $words === false ? [] : $words;
    }
}
