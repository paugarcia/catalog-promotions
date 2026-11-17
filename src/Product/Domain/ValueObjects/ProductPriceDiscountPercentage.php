<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductPriceDiscountPercentageException;


final readonly class ProductPriceDiscountPercentage
{
    public function __construct(private string $productPriceDiscountPercentage)
    {
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
