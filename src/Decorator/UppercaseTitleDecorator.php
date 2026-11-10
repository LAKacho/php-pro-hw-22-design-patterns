<?php

declare(strict_types=1);

namespace DesignPatterns\Decorator;

final class UppercaseTitleDecorator extends DocumentDecorator
{
    public function title(): string
    {
        return mb_strtoupper($this->document->title());
    }
}
