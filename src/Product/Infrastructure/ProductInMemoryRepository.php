<?php

namespace Catalog\Product\Infrastructure;

use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

final class ProductInMemoryRepository implements ProductRepository
{
    private array $products = [
        '000001' => [
            'sku' => '000001',
            'name' => 'BV Lean leather ankle boots',
            'category' => 'boots',
            'price' => 89000,
        ],
        '000002' => [
            'sku' => '000002',
            'name' => 'BV Lean leather ankle boots',
            'category' => 'boots',
            'price' => 99000,
        ],
        '000003' => [
            'sku' => '000003',
            'name' => 'Ashlington leather ankle boots',
            'category' => 'boots',
            'price' => 89000,
        ],
        '000004' => [
            'sku' => '000004',
            'name' => 'Naima embellished suede sandals',
            'category' => 'sandals',
            'price' => 79500,
        ],
        '000005' => [
            'sku' => '000005',
            'name' => 'Nathane leather sneakers',
            'category' => 'sneakers',
            'price' => 59000,
        ],
    ];

    public function getAll(): array
    {
        $productsList = [];

        foreach ($this->products as $product) {
            $productsList[$product['sku']] = Product::create(
                new ProductSku($product['sku']),
                new ProductName($product['name']),
                new ProductCategory($product['category']),
                new ProductPrice($product['price'])
            );
        }

        return $productsList;
    }

    public function save(Product $product): void
    {
        $this->products[$product->productSku()->value()] = [
            'sku' => $product->productSku()->value(),
            'name' => $product->productName()->value(),
            'category' => $product->productCategory()->value(),
            'price' => $product->productPrice()->value()
        ];
    }

    public function getBySku(ProductSku $sku): ?Product
    {
        $product = null;

        if (!empty($this->products[$sku->value()])){
            $product = Product::create(
                new ProductSku($this->products[$sku->value()]['sku']),
                new ProductName($this->products[$sku->value()]['name']),
                new ProductCategory($this->products[$sku->value()]['category']),
                new ProductPrice($this->products[$sku->value()]['price'])
            );
        }

        return $product;
    }
    public function getByProductCategory(ProductCategory $category): array
    {
        $productsList = [];

        foreach ($this->products as $product) {
            if($category->value() === $product['category']){
                $productsList[$product['sku']] = Product::create(
                    new ProductSku($product['sku']),
                    new ProductName($product['name']),
                    new ProductCategory($product['category']),
                    new ProductPrice($product['price'])
                );
            }
        }

        return $productsList;
    }
}