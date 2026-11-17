<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductSkuException;

final readonly class ProductSku
{
    public function __construct(private string $sku)
    {
        $this->validateSku($sku);
    }

    public function value(): string
    {
        return $this->sku;
    }

    private function validateSku(string $sku): void
    {
        if (trim($sku) === '') {
            throw new InvalidProductSkuException("Invalid product sku, can't be empty.");
        }
    }
}
