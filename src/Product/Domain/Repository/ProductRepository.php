<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Product;
use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\ProductCategory;

interface ProductRepository
{
    public function getAll(): array;
    public function save(Product $product): void;
    public function getBySku(ProductSku $sku): ?Product;
    public function getByProductCategory(ProductCategory $category): array;
}