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
use DesignPatterns\Strategy\PerWordPricing;
use DesignPatterns\TemplateMethod\ContractGenerator;
use DesignPatterns\TemplateMethod\ReportGenerator;
function assertSameValue(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new \RuntimeException(sprintf(
            "%s\nОжидалось: %s\nПолучено: %s",
            $message,
            var_export($expected, true),
            var_export($actual, true),
        ));
    }
}

function expectDomainException(callable $action, string $message): void
{
    try {
        $action();
    } catch (\DomainException $exception) {
        assertSameValue($message, $exception->getMessage(), 'Получено неверное сообщение ошибки.');
        return;
    }

    throw new \RuntimeException('Ожидалось исключение DomainException.');
}


$contract = new ContractGenerator('14', new \DateTimeImmutable('2026-11-10'));
$report = new ReportGenerator('15', 125000);
assertSameValue('Контракт № 14' . PHP_EOL . 'Дата: 10.11.2026' . PHP_EOL, $contract->generate('Дата: #date'), 'Ошибка Template Method для контракта.');
assertSameValue('Отчёт № 15' . PHP_EOL . 'Прибыль: 125000' . PHP_EOL, $report->generate('Прибыль: #income'), 'Ошибка Template Method для отчёта.');
echo "[OK] Шаблонный метод\n";


$documents = [new Document('Один два три'), new Document('Очень длинное слово')];
assertSameValue(6, (new DocumentPricingService(new PerWordPricing()))->totalFor($documents), 'Ошибка стратегии оплаты за каждое слово.');
assertSameValue(8, (new DocumentPricingService(new LongWordPricing()))->totalFor($documents), 'Ошибка стратегии оплаты за длинные слова.');
echo "[OK] Стратегия\n";


$logger = new InMemoryLogger();
$decorated = new UppercaseTitleDecorator(
    new LoggingDocumentDecorator(new PlainDocument('Отчёт за ноябрь'), $logger),
);
assertSameValue('ОТЧЁТ ЗА НОЯБРЬ', $decorated->title(), 'Декоратор не изменил заголовок.');
assertSameValue(['Запрошен заголовок документа'], $logger->messages(), 'Логирующий декоратор не был вызван.');
echo "[OK] Декоратор\n";


$loader = new InMemoryReviewsLoader([7 => ['*****', '****']]);
$proxy = new LazyReviewsDocumentProxy(7, 'Контракт', $loader);
assertSameValue('Контракт', $proxy->title(), 'Прокси не вернул заголовок.');
assertSameValue(0, $loader->calls(), 'Отзывы загрузились раньше времени.');
assertSameValue(['*****', '****'], $proxy->reviews(), 'Прокси не загрузил отзывы.');
assertSameValue(['*****', '****'], $proxy->reviews(), 'Прокси не вернул кеш отзывов.');
assertSameValue(1, $loader->calls(), 'Прокси должен загрузить отзывы ровно один раз.');
echo "[OK] Прокси\n";


$chain = new AuthenticationHandler();
$chain
    ->setNext(new AntispamHandler(['192.0.2.10']))
    ->setNext(new BlacklistHandler(['Вася']));
$chain->handle(new Request('Анна', '192.0.2.1'));
expectDomainException(
    static fn () => $chain->handle(new Request('', '192.0.2.1')),
    'Пользователь не аутентифицирован',
);
expectDomainException(
    static fn () => $chain->handle(new Request('Анна', '192.0.2.10')),
    'Доступ запрещён по IP',
);
expectDomainException(
    static fn () => $chain->handle(new Request('Вася', '192.0.2.1')),
    'Пользователь заблокирован',
);
echo "[OK] Цепочка обязанностей\n";

echo "Все 5 паттернов работают корректно.\n";
