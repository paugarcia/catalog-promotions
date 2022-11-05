<?php

namespace App\Product\Domain\Repository;

interface ProductDiscountRepository
{
    public function getAll(): array;
}