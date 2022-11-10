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

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductShouldBeCreated(): void
    {
        $sku = "000000";
        $name = "Product name example";
        $category = "Product category";
        $price = 10;

        $product = new Product(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );

        $this->assertInstanceOf(Product::class, $product);

        $this->assertEquals($sku, $product->sku()->value());
        $this->assertEquals($name, $product->name()->value());
        $this->assertEquals($category, $product->category()->value());
        $this->assertEquals($price, $product->price()->value());
    }

    public function testProductWithoutSkuShouldNotBeCreated(): void
    {
        $sku = "";
        $name = "Product name example";
        $category = "Product category";
        $price = 10;

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
        $sku = "000000";
        $name = "";
        $category = "Product category";
        $price = 10;

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
        $sku = "000000";
        $name = "Product name example";
        $category = "";
        $price = 10;

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
        $sku = "000000";
        $name = "Product name example";
        $category = "Product category";
        $price = -1;

        $this->expectException(InvalidProductPriceException::class);

        new Product(
            new ProductSku($sku),
            new ProductName($name),
            new ProductCategory($category),
            new ProductPrice($price)
        );
    }
}