<?php

declare(strict_types=1);

namespace DesignPatterns\TemplateMethod;

final class ReportGenerator extends AbstractDocumentGenerator
{
    public function __construct(
        string $documentNumber,
        private readonly int $income,
    ) {
        parent::__construct($documentNumber);
    }

    protected function createTitle(): string
    {
        return "Отчёт № {$this->documentNumber}";
    }

    protected function processTemplate(string $template): string
    {
        return str_replace('#income', (string) $this->income, $template);
    }
}
