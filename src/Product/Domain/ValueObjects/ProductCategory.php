<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductCategoryException;

final class ProductCategory
{
    private readonly string $category;

    public function __construct(string $category)
    {
        $this->validateCategory($category);
        $this->category = $category;
    }

    public function value(): string
    {
        return $this->category;
    }

    private function validateCategory(string $category): void
    {
        if (trim($category) === '') {
            throw new InvalidProductCategoryException("Invalid product category, can't be empty.");
        }
    }
}
