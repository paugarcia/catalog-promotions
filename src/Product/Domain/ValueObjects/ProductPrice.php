<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductPriceException;

final readonly class ProductPrice
{
    public function __construct(private int $price)
    {
        $this->validateProductPrice($price);
    }

    public function value(): int
    {
        return $this->price;
    }

    private function validateProductPrice(int $price): void
    {
        if ($price <= 0) {
            throw new InvalidProductPriceException(
                sprintf("Invalid price (%s), must be greater than 0.", $price)
            );
        }
    }
}
