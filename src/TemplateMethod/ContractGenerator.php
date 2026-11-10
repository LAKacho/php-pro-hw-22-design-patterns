<?php

declare(strict_types=1);

namespace DesignPatterns\TemplateMethod;

use DateTimeInterface;

final class ContractGenerator extends AbstractDocumentGenerator
{
    public function __construct(
        string $documentNumber,
        private readonly DateTimeInterface $contractDate,
    ) {
        parent::__construct($documentNumber);
    }

    protected function createTitle(): string
    {
        return "Контракт № {$this->documentNumber}";
    }

    protected function processTemplate(string $template): string
    {
        return str_replace('#date', $this->contractDate->format('d.m.Y'), $template);
    }
}
