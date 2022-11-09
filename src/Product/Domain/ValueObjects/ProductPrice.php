<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductPriceException;

final class ProductPrice
{
    private int $price;

    public function __construct(int $price)
    {
        $this->validateProductPrice($price);
        $this->price = $price;
    }

    public function value(): int
    {
        return $this->price;
    }

    private function validateProductPrice(int $price): void
    {
        if ($price <= 0){
            throw new InvalidProductPriceException(
                sprintf("Invalid price (%s), must be more than 0", $price)
            );
        }
    }
}