<?php

namespace App\Product\Infrastructure;

use App\Product\Domain\Product;
use App\Product\Domain\Repository\ProductDiscountRepository;

use App\Product\Domain\ProductDiscount;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\DiscountPercentage;
use App\Product\Domain\ValueObjects\ProductCategory;


final class ProductDiscountInMemoryRepository implements ProductDiscountRepository
{
    /** @var ProductDiscount[] */
    private array $productDiscounts = [];

    public function getAll(): array
    {
        $discountList = [];

        if (!empty($this->productDiscounts)) {
            foreach ($this->productDiscounts as $discount) {
                $discountList[] = new ProductDiscount(
                    new DiscountPercentage($discount['percentage']),
                    ($discount['sku'] != null) ? new ProductSku($discount['sku']) : null,
                    ($discount['category'] != null) ? new ProductCategory($discount['category']) : null
                );
            }
        }

        return $discountList;
    }

    public function save(ProductDiscount $productDiscount): void
    {
        $this->productDiscounts[] = [
            'percentage' => $productDiscount->percentage()->value(),
            'sku' => ($productDiscount->sku() != null) ? $productDiscount->sku()->value() : null,
            'category' => ($productDiscount->category() != null) ? $productDiscount->category()->value() : null,
        ];
    }
}