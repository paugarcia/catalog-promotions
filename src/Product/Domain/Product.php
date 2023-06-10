<?php

namespace Catalog\Product\Domain;

use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

final class Product
{
    public function __construct(
        private readonly ProductSku $productSku,
        private readonly ProductName $productName,
        private readonly ProductCategory $productCategory,
        private readonly ProductPrice $productPrice
    ) {
    }

    public static function create(
        ProductSku $productSku,
        ProductName $productName,
        ProductCategory $productCategory,
        ProductPrice $productPrice
    ): self {
        return new self($productSku, $productName, $productCategory, $productPrice);
    }

    public function productSku(): ProductSku
    {
        return $this->productSku;
    }

    public function productName(): ProductName
    {
        return $this->productName;
    }

    public function productCategory(): ProductCategory
    {
        return $this->productCategory;
    }

    public function productPrice(): ProductPrice
    {
        return $this->productPrice;
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->productSku->value(),
            'name' => $this->productName->value(),
            'category' => $this->productCategory->value(),
            'price' => $this->productPrice->value()
        ];
    }
}