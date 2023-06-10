<?php

namespace App\Tests\Product\Domain;

use Catalog\Product\Domain\Product;

use Catalog\Product\Domain\Exceptions\InvalidProductSkuException;
use Catalog\Product\Domain\Exceptions\InvalidProductNameException;
use Catalog\Product\Domain\Exceptions\InvalidProductCategoryException;
use Catalog\Product\Domain\Exceptions\InvalidProductPriceException;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

use App\Tests\Shared\TestInfrastructure\CatalogTest;

class ProductTest extends CatalogTest
{
    public function testProductShouldBeCreated(): void
    {
        $sku = $this->faker->numerify('sku-####');
        $name = $this->faker->company();
        $category = $this->faker->company();
        $price = $this->faker->numberBetween(1, 99);

        $product = new Product(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );

        $this->assertInstanceOf(Product::class, $product);

        $this->assertEquals($sku, $product->productSku()->value());
        $this->assertEquals($name, $product->productName()->value());
        $this->assertEquals($category, $product->productCategory()->value());
        $this->assertEquals($price, $product->productPrice()->value());
    }

    public function testProductWithoutSkuShouldNotBeCreated(): void
    {
        $sku = "";
        $name = $this->faker->company();
        $category = $this->faker->company();
        $price = $this->faker->numberBetween(1, 99);

        $this->expectException(InvalidProductSkuException::class);

        new Product(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );
    }

    public function testProductWithoutNameShouldNotBeCreated(): void
    {
        $sku = $this->faker->numerify('sku-####');
        $name = "";
        $category = $this->faker->company();
        $price = $this->faker->numberBetween(1, 99);

        $this->expectException(InvalidProductNameException::class);

        new Product(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );
    }

    public function testProductWithoutCategoryShouldNotBeCreated(): void
    {
        $sku = $this->faker->numerify('sku-####');
        $name = $this->faker->company();
        $category = "";
        $price = $this->faker->numberBetween(1, 99);

        $this->expectException(InvalidProductCategoryException::class);

        new Product(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );
    }

    public function testProductWithPriceLessThan0ShouldNotBeCreated(): void
    {
        $sku = $this->faker->numerify('sku-####');
        $name = $this->faker->company();
        $category = $this->faker->company();
        $price = $this->faker->numberBetween(-1, -100);

        $this->expectException(InvalidProductPriceException::class);

        new Product(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );
    }
}