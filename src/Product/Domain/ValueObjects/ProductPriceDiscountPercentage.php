<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductPriceDiscountPercentageException;


final class ProductPriceDiscountPercentage
{
    private readonly string $productPriceDiscountPercentage;

    public function __construct(string $productPriceDiscountPercentage)
    {
        $this->productPriceDiscountPercentage = $productPriceDiscountPercentage;
        $this->validateFormat();
    }

    public function value(): string
    {
        return $this->productPriceDiscountPercentage;
    }

    private function validateFormat(): void
    {
        if (substr($this->productPriceDiscountPercentage, -1) !== '%') {
            throw new InvalidProductPriceDiscountPercentageException(
                "Invalid format in ProductPriceDiscountPercentage, must end with '%'"
            );
        }
    }
}
