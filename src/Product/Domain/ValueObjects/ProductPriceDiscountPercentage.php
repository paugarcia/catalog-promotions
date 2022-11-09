<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductPriceDiscountPercentageException;


final class ProductPriceDiscountPercentage
{
    private ?string $productPriceDiscountPercentage;

    public function __construct(?string $productPriceDiscountPercentage)
    {

        $this->productPriceDiscountPercentage = $productPriceDiscountPercentage;
        $this->validateFormat();
    }

    public function value(): ?string
    {
        return $this->productPriceDiscountPercentage;
    }


    private function validateFormat(): void
    {
        if($this->productPriceDiscountPercentage !== null && !strpos($this->productPriceDiscountPercentage, "%")){
            throw new InvalidProductPriceDiscountPercentageException(
                sprintf("Invalid format in ProductPriceDiscountPercentage, must have '%'")
            );
        }
    }
}