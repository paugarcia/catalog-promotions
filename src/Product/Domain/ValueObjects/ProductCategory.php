<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductCategoryException;

final readonly class ProductCategory
{
    public function __construct(private string $category)
    {
        $this->validateCategory($category);
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
