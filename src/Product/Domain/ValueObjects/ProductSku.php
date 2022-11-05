<?php

namespace App\Product\Domain\ValueObjects;

use App\Product\Domain\Exceptions\InvalidProductSkuException;

final class ProductSku
{
    private string $sku;

    public function __construct(string $sku)
    {
        $this->validatSku($sku);
        $this->sku = $sku;
    }

    public function value(): string
    {
        return $this->sku;
    }

    private function validatSku($sku): void
    {
        if (empty($sku)){
            throw new InvalidProductSkuException(sprintf("Invalid product sku, can't be empty."));
        }
    }
}