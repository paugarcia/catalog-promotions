<?php

namespace Catalog\Product\Infrastructure;

use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\Repository\ProductDiscountRepository;
use Catalog\Product\Domain\ValueObjects\DiscountPercentage;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductSku;


final class ProductDiscountInMemoryRepository implements ProductDiscountRepository
{
    private array $productDiscounts = [
        [
            'percentage' => 30,
            'sku' => null,
            'category' => 'boots',
        ],
        [
            'percentage' => 15,
            'sku' => '000003',
            'category' => null,
        ],
    ];

    public function getAll(): array
    {
        $discountList = [];

        if (!empty($this->productDiscounts)) {
            foreach ($this->productDiscounts as $discount) {
                $discountList[] = ProductDiscount::create(
                    new DiscountPercentage($discount['percentage']),
                    ($discount['sku'] != null) ? new ProductSku($discount['sku']) : null,
                    ($discount['category'] != null) ? new ProductCategory($discount['category']) : null
                );
            }
        }

        return $discountList;
    }

    public function findPromotionsByProduct(Product $product){

    }

    public function save(ProductDiscount $productDiscount): void
    {
        $this->productDiscounts[] = [
            'percentage' => $productDiscount->discountPercentage()->value(),
            'sku' => ($productDiscount->productSku() != null) ? $productDiscount->productSku()->value() : null,
            'category' => ($productDiscount->productCategory() != null) ? $productDiscount->productCategory()->value() : null,
        ];
    }
}