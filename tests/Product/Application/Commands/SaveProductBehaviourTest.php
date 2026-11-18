<?php

namespace App\Tests\Product\Application\Commands;

use App\Tests\Shared\TestInfrastructure\CatalogTest;

use Catalog\Product\Domain\Product;

use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommand;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommandHandler;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductApplicationService;
use Catalog\Product\Domain\Exceptions\ProductAlreadyExistByIdException;
use Catalog\Product\Domain\Exceptions\ProductAlreadyExistBySkuException;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductId;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

class SaveProductBehaviourTest extends CatalogTest
{
    public function testProductShouldBeSaved()
    {
        $productId = $this->faker->uuid();
        $sku = $this->faker->numerify('sku-####');
        $name = $this->faker->company();
        $category = $this->faker->company();
        $price = $this->faker->numberBetween(1, 99);

        $product = Product::create(
            new ProductId($productId),
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );

        $productRepositoryMock = $this->createMock(ProductRepository::class);

        $command = new SaveProductCommand($productId, $sku, $name, $category, $price);
        $commandHandler = new SaveProductCommandHandler(new SaveProductApplicationService($productRepositoryMock));

        $productRepositoryMock
            ->expects($this->once())
            ->method('getById');

        $productRepositoryMock
            ->expects($this->once())
            ->method('getBySku');

        $productRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->equalTo($product));

        $commandHandler->handle($command);
    }

    public function testSavingTheSameProductTwiceShouldBeIdempotent(): void
    {
        $product = $this->createProduct();
        $productRepositoryMock = $this->createMock(ProductRepository::class);
        $service = new SaveProductApplicationService($productRepositoryMock);

        $productRepositoryMock
            ->expects($this->once())
            ->method('getById')
            ->with($product->productId())
            ->willReturn($product);

        $productRepositoryMock->expects($this->never())->method('getBySku');
        $productRepositoryMock->expects($this->never())->method('save');

        $service->save(
            $product->productId(),
            $product->productSku(),
            $product->productName(),
            $product->productCategory(),
            $product->productPrice()
        );
    }

    public function testProductWithExistingIdAndDifferentDataShouldNotBeSaved(): void
    {
        $product = $this->createProduct();
        $existingProduct = Product::create(
            $product->productId(),
            $product->productSku(),
            new ProductName('Different product name'),
            $product->productCategory(),
            $product->productPrice()
        );
        $productRepositoryMock = $this->createMock(ProductRepository::class);
        $service = new SaveProductApplicationService($productRepositoryMock);

        $productRepositoryMock->method('getById')->willReturn($existingProduct);
        $productRepositoryMock->expects($this->never())->method('getBySku');
        $productRepositoryMock->expects($this->never())->method('save');

        $this->expectException(ProductAlreadyExistByIdException::class);
        $this->expectExceptionMessage(
            sprintf(ProductAlreadyExistByIdException::MESSAGE_TEMPLATE, $product->productId()->value())
        );

        $service->save(
            $product->productId(),
            $product->productSku(),
            $product->productName(),
            $product->productCategory(),
            $product->productPrice()
        );
    }

    public function testProductWithExistingSkuShouldNotBeSaved(): void
    {
        $product = $this->createProduct();
        $productRepositoryMock = $this->createMock(ProductRepository::class);
        $service = new SaveProductApplicationService($productRepositoryMock);

        $productRepositoryMock->method('getById')->willReturn(null);
        $productRepositoryMock->method('getBySku')->willReturn($product);
        $productRepositoryMock->expects($this->never())->method('save');

        $this->expectException(ProductAlreadyExistBySkuException::class);
        $this->expectExceptionMessage(
            sprintf(ProductAlreadyExistBySkuException::MESSAGE_TEMPLATE, $product->productSku()->value())
        );

        $service->save(
            new ProductId($this->faker->uuid()),
            $product->productSku(),
            $product->productName(),
            $product->productCategory(),
            $product->productPrice()
        );
    }

    private function createProduct(): Product
    {
        return Product::create(
            new ProductId($this->faker->uuid()),
            new ProductSku($this->faker->numerify('sku-####')),
            new ProductName($this->faker->company()),
            new ProductCategory($this->faker->company()),
            new ProductPrice($this->faker->numberBetween(1, 99))
        );
    }
}
