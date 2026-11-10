<?php

declare(strict_types=1);

namespace DesignPatterns\TemplateMethod;

abstract class AbstractDocumentGenerator
{
    public function __construct(protected readonly string $documentNumber)
    {
    }

    final public function generate(string $template): string
    {
        $title = $this->createTitle();
        $body = $this->processTemplate($template);

        return $title . PHP_EOL . $body . PHP_EOL;
    }

    abstract protected function createTitle(): string;

    abstract protected function processTemplate(string $template): string;
}
