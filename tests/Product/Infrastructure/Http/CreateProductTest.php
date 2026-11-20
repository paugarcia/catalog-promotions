<?php

namespace App\Tests\Product\Infrastructure\Http;

use App\Kernel;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductApplicationService;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommandHandler;
use Catalog\Product\Infrastructure\Persistence\Memory\ProductInMemoryRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateProductTest extends TestCase
{
    private const ID = '10000000-0000-4000-8000-000000000099';
    private const BODY = '{"sku":"new-sku","name":"New product","category":"boots","price":12345}';

    public function testCreatesProductAndRejectsDuplicates(): void
    {
        $repository = new ProductInMemoryRepository();
        $response = $this->request(self::ID, self::BODY, $repository);
        self::assertSame(201, $response->getStatusCode());
        self::assertSame('/api/products/' . self::ID, $response->headers->get('Location'));
        self::assertSame(409, $this->request(self::ID, self::BODY, $repository)->getStatusCode());
        self::assertSame(409, $this->request('10000000-0000-4000-8000-000000000098', self::BODY, $repository)->getStatusCode());
    }

    public function testRejectsInvalidInput(): void
    {
        foreach ([
            ['invalid', self::BODY],
            [self::ID, '{'],
            [self::ID, '{}'],
            [self::ID, '{"sku":"x","name":"x","category":"x","price":"123"}'],
            [self::ID, '{"sku":"x","name":"","category":"x","price":123}'],
            [self::ID, '{"sku":"x","name":"x","category":"x","price":0}'],
        ] as [$id, $body]) {
            self::assertSame(400, $this->request($id, $body)->getStatusCode());
        }
    }

    private function request(string $id, string $body, ?ProductInMemoryRepository $repository = null): Response
    {
        $kernel = new Kernel('test', true);
        try {
            if ($repository !== null) {
                $kernel->boot();
                $kernel->getContainer()->get('test.service_container')->set(SaveProductCommandHandler::class, new SaveProductCommandHandler(new SaveProductApplicationService($repository)));
            }
            return $kernel->handle(Request::create('/api/products/' . $id, 'PUT', [], [], [], ['CONTENT_TYPE' => 'application/json'], $body));
        } finally {
            $kernel->shutdown();
        }
    }
}
