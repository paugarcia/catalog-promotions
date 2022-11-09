<?php

namespace Catalog\Product\Domain\Repository;

use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductSku;

interface ProductRepository
{
    public function getAll(): array;
    public function save(Product $product): void;
    public function getBySku(ProductSku $sku): ?Product;
    public function getByProductCategory(ProductCategory $category): array;
}