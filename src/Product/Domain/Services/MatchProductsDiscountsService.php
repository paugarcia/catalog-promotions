<?php

namespace Catalog\Product\Domain\Services;

use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\ProductPriceSummary;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductPriceDiscountPercentage;
use Catalog\Shared\Domain\ValueObjects\Currency;

final class MatchProductsDiscountsService
{
    /**
     * @param Product[] $products
     * @param ProductDiscount[] $discounts
     * @return array
     */
    public function __invoke(array $products, array $discounts): array
    {
        return array_map(
            function (Product $product) use ($discounts): array {
                $productArray = $product->toArray();
                $productArray['price'] = $this->matchProductBestDiscount($product, $discounts)->toArray();

                return $productArray;
            },
            $products
        );
    }

    /**
     * @param Product $product
     * @param ProductDiscount[] $discounts
     * @return ProductPriceSummary
     */
    private function matchProductBestDiscount(Product $product, array $discounts): ProductPriceSummary
    {
        $originalPriceValue = $product->productPrice()->value();
        $bestPrice = $originalPriceValue;
        $bestDiscount = null;

        foreach ($discounts as $discount) {
            if (!$this->discountAppliesTo($product, $discount)) {
                continue;
            }

            $discountedPrice = $originalPriceValue * (1 - $discount->discountPercentage()->value() / 100);

            if ($discountedPrice < $bestPrice) {
                $bestPrice = $discountedPrice;
                $bestDiscount = $discount->discountPercentage()->toString();
            }
        }

        return ProductPriceSummary::create(
            $product->productPrice(),
            new ProductPrice($bestPrice),
            new Currency('EUR'),
            $bestDiscount !== null ? new ProductPriceDiscountPercentage($bestDiscount) : null
        );
    }

    private function discountAppliesTo(Product $product, ProductDiscount $discount): bool
    {
        $skuMatches = $discount->productSku() !== null
            && $discount->productSku()->value() === $product->productSku()->value();
        $categoryMatches = $discount->productCategory() !== null
            && $discount->productCategory()->value() === $product->productCategory()->value();

        return $skuMatches || $categoryMatches;
    }
}
