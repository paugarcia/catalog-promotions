<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\Product;
// use App\Product\Domain\ValueObjects\ProductId;

interface ProductRepository
{
    public function save(Product $product): void;
    //public function getById(ProductId $id): ?Product;
    //public function delete(ProductId $id): void;
}