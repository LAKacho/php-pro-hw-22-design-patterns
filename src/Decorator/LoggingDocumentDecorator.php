<?php

declare(strict_types=1);

namespace DesignPatterns\Decorator;

final class LoggingDocumentDecorator extends DocumentDecorator
{
    public function __construct(Document $document, private readonly Logger $logger)
    {
        parent::__construct($document);
    }

    public function title(): string
    {
        $this->logger->log('Запрошен заголовок документа');

        return $this->document->title();
    }
}
