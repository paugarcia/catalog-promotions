<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Product;
use App\Product\Domain\ValueObjects\ProductSku;

interface ProductRepository
{
    public function save(Product $product): void;
    public function getAll(): array;
    public function getBySku(ProductSku $sku): ?Product;
    public function delete(ProductSku $sku): void;
}