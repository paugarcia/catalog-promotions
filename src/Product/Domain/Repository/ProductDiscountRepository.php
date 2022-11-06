<?php

namespace App\Product\Domain\Repository;

use App\Product\Domain\ProductDiscount;

interface ProductDiscountRepository
{
    public function getAll(): array;
    public function save(ProductDiscount $productDiscount): void;
}