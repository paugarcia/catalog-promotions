<?php

namespace App\Tests\Product\Application\Commands;

use App\Tests\Shared\TestInfrastructure\CatalogTest;

use Catalog\Product\Domain\Product;

use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommand;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommandHandler;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductApplicationService;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

class SaveProductBehaviourTest extends CatalogTest
{
    public function testProductShouldBeSaved()
    {
        $sku = $this->faker->numerify('sku-####');
        $name = $this->faker->company();
        $category = $this->faker->company();
        $price = $this->faker->numberBetween(1, 99);

        $product = Product::create(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );

        $productRepositoryMock = $this->createMock(ProductRepository::class);

        $command = new SaveProductCommand($sku, $name, $category, $price);
        $commandHandler = new SaveProductCommandHandler(new SaveProductApplicationService($productRepositoryMock));

        $productRepositoryMock
            ->expects($this->once())
            ->method('getBySku');

        $productRepositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->equalTo($product));

        $commandHandler->handle($command);
    }
}