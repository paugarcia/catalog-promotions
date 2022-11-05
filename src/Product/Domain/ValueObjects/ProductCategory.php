<?php

namespace App\Product\Domain\ValueObjects;

use App\Product\Domain\Exceptions\InvalidProductCategoryException;

final class ProductCategory
{
    private string $category;

    public function __construct(string $category)
    {
        $this->validateCategory($category);
        $this->category = $category;
    }

    public function value(): string
    {
        return $this->category;
    }

    private function validateCategory($category): void
    {
        if (empty($category)){
            throw new InvalidProductCategoryException(sprintf("Invalid product category, can't be empty."));
        }
    }
}