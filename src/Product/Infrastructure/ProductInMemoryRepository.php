<?php

namespace App\Product\Infrastructure;

use App\Product\Domain\Product;

use App\Product\Domain\Repository\ProductRepository;

use App\Product\Domain\ValueObjects\ProductName;
use App\Product\Domain\ValueObjects\ProductPrice;
use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\ProductCategory;

final class ProductInMemoryRepository implements ProductRepository
{
    /** @var Product[] */
    private array $products = [];

    public function getAll(): array
    {
        $productsList = [];

        foreach ($this->products as $product) {
            $productsList[] = new Product(
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
        $this->products[] = [
            'sku' => $product->sku()->value(),
            'name' => $product->name()->value(),
            'category' => $product->category()->value(),
            'price' => $product->price()->value()
        ];
    }

    public function getBySku(ProductSku $sku): ?Product
    {
        return null;
    }
    public function getByProductCategory(ProductCategory $category): array
    {
        return [];
    }
}