<?php

namespace App\Tests\Product\Infrastructure\Persistence\Memory;

use App\Tests\Shared\TestInfrastructure\CatalogTest;
use Catalog\Product\Domain\ValueObjects\ProductId;
use Catalog\Product\Infrastructure\Persistence\Memory\ProductInMemoryRepository;

final class ProductInMemoryRepositoryTest extends CatalogTest
{
    private ProductInMemoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductInMemoryRepository();
    }

    public function testShouldGetProductById(): void
    {
        $productId = new ProductId('10000000-0000-4000-8000-000000000001');

        $product = $this->repository->getById($productId);

        self::assertNotNull($product);
        self::assertSame($productId->value(), $product->productId()->value());
    }

    public function testShouldReturnNullWhenProductIdDoesNotExist(): void
    {
        $productId = new ProductId('10000000-0000-4000-8000-999999999999');

        self::assertNull($this->repository->getById($productId));
    }
}
