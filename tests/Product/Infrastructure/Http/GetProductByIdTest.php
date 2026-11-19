<?php

namespace App\Tests\Product\Infrastructure\Http;

use App\Kernel;
use Catalog\Product\Application\Queries\GetProductById\GetProductByIdApplicationService;
use Catalog\Product\Application\Queries\GetProductById\GetProductByIdQueryHandler;
use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductId;
use Catalog\Product\Domain\ValueObjects\ProductSku;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetProductByIdTest extends TestCase
{
    public function testReturnsProductForExistingId(): void
    {
        $product = Product::create(
            new ProductId('10000000-0000-4000-8000-000000000099'),
            new ProductSku('test-sku'),
            new ProductName('Test product'),
            new ProductCategory('test-category'),
            new ProductPrice(12345),
        );
        $repository = $this->createMock(ProductRepository::class);
        $repository->expects(self::once())
            ->method('getById')
            ->with(self::callback(fn (ProductId $id) => $id->value() === $product->productId()->value()))
            ->willReturn($product);

        $response = $this->request('/api/products/' . $product->productId()->value(), 'GET', $repository);

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame([
            'productId' => $product->productId()->value(),
            'sku' => $product->productSku()->value(),
            'name' => $product->productName()->value(),
            'category' => $product->productCategory()->value(),
            'price' => $product->productPrice()->value(),
        ], json_decode($response->getContent(), true));
    }

    public function testReturnsNotFoundForUnknownId(): void
    {
        $repository = $this->createMock(ProductRepository::class);
        $repository->expects(self::once())->method('getById')->willReturn(null);
        self::assertSame(Response::HTTP_NOT_FOUND, $this->request('/api/products/10000000-0000-4000-8000-999999999999', 'GET', $repository)->getStatusCode());
    }

    public function testReturnsBadRequestForInvalidId(): void
    {
        self::assertSame(Response::HTTP_BAD_REQUEST, $this->request('/api/products/invalid')->getStatusCode());
    }

    public function testOnlyAllowsGet(): void
    {
        self::assertSame(Response::HTTP_METHOD_NOT_ALLOWED, $this->request('/api/products/10000000-0000-4000-8000-000000000001', 'POST')->getStatusCode());
    }

    private function request(string $path, string $method = 'GET', ?ProductRepository $repository = null): Response
    {
        $kernel = new Kernel('test', true);
        try {
            if ($repository !== null) {
                $kernel->boot();
                $kernel->getContainer()->get('test.service_container')->set(GetProductByIdQueryHandler::class, new GetProductByIdQueryHandler(new GetProductByIdApplicationService($repository)));
            }
            return $kernel->handle(Request::create($path, $method));
        } finally {
            $kernel->shutdown();
        }
    }
}
