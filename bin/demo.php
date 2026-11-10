<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DesignPatterns\ChainOfResponsibility\AntispamHandler;
use DesignPatterns\ChainOfResponsibility\AuthenticationHandler;
use DesignPatterns\ChainOfResponsibility\BlacklistHandler;
use DesignPatterns\ChainOfResponsibility\Request;
use DesignPatterns\Decorator\InMemoryLogger;
use DesignPatterns\Decorator\LoggingDocumentDecorator;
use DesignPatterns\Decorator\PlainDocument;
use DesignPatterns\Decorator\UppercaseTitleDecorator;
use DesignPatterns\Proxy\InMemoryReviewsLoader;
use DesignPatterns\Proxy\LazyReviewsDocumentProxy;
use DesignPatterns\Strategy\Document;
use DesignPatterns\Strategy\DocumentPricingService;
use DesignPatterns\Strategy\LongWordPricing;
use DesignPatterns\TemplateMethod\ContractGenerator;

echo "1. Шаблонный метод\n";
$generator = new ContractGenerator('42', new \DateTimeImmutable('2026-11-10'));
echo $generator->generate('Дата документа: #date') . PHP_EOL;

echo "2. Стратегия\n";
$pricing = new DocumentPricingService(new LongWordPricing());
echo 'Стоимость: ' . $pricing->totalFor([new Document('Пример длинного заголовка')]) . PHP_EOL . PHP_EOL;

echo "3. Декоратор\n";
$logger = new InMemoryLogger();
$document = new LoggingDocumentDecorator(
    new UppercaseTitleDecorator(new PlainDocument('Ежемесячный отчёт')),
    $logger,
);
echo $document->title() . PHP_EOL;
echo implode(PHP_EOL, $logger->messages()) . PHP_EOL . PHP_EOL;

echo "4. Прокси\n";
$loader = new InMemoryReviewsLoader([1 => ['Отлично', 'Хорошо']]);
$proxy = new LazyReviewsDocumentProxy(1, 'Контракт', $loader);
echo $proxy->title() . ' (загрузок отзывов: ' . $loader->calls() . ')' . PHP_EOL;
echo implode(', ', $proxy->reviews()) . ' (загрузок отзывов: ' . $loader->calls() . ')' . PHP_EOL . PHP_EOL;

echo "5. Цепочка обязанностей\n";
$chain = new AuthenticationHandler();
$chain
    ->setNext(new AntispamHandler(['192.0.2.10']))
    ->setNext(new BlacklistHandler(['Вася']));
$chain->handle(new Request('Анна', '192.0.2.1'));
echo "Запрос прошёл все проверки.\n";
