<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductSkuException;

final class ProductSku
{
    private readonly string $sku;

    public function __construct(string $sku)
    {
        $this->validateSku($sku);
        $this->sku = $sku;
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
