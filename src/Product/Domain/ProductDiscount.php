<?php

namespace Catalog\Product\Domain;

use Catalog\Product\Domain\Exceptions\InvalidProductDiscountException;
use Catalog\Product\Domain\ValueObjects\DiscountPercentage;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductSku;

final class ProductDiscount
{
    public function __construct(
        private readonly DiscountPercentage $discountPercentage,
        private readonly ?ProductSku $productSku,
        private readonly ?ProductCategory $productCategory
    ) {
        $this->validateParams();
    }

    public static function create(
        DiscountPercentage $discountPercentage,
        ?ProductSku $productSku,
        ?ProductCategory $productCategory
    ): self {
        return new self($discountPercentage, $productSku, $productCategory);
    }

    public function productSku(): ?ProductSku
    {
        return $this->productSku;
    }

    public function discountPercentage(): DiscountPercentage
    {
        return $this->discountPercentage;
    }

    public function productCategory(): ?ProductCategory
    {
        return $this->productCategory;
    }

    public function toArray(): array
    {
        return [
            'percentage' => $this->discountPercentage()->value(),
            'sku' => (null !== $this->productSku) ? $this->productSku()->value() : null,
            'category' => (null !== $this->productCategory) ? $this->productCategory()->value() : null,
        ];
    }

    private function validateParams(): void
    {
        if ($this->productSku === null && $this->productCategory === null) {
            throw new InvalidProductDiscountException(
                sprintf("ProductDiscount not created - Invalid sku and category")
            );
        }
    }
}