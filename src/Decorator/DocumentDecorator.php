<?php

declare(strict_types=1);

namespace DesignPatterns\Decorator;

abstract class DocumentDecorator implements Document
{
    public function __construct(protected readonly Document $document)
    {
    }
}
