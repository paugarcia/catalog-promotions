<?php

namespace Catalog\Product\Domain\Repository;

use Catalog\Product\Domain\ProductDiscount;

interface ProductDiscountRepository
{
    public function getAll(): array;
    public function save(ProductDiscount $productDiscount): void;
}