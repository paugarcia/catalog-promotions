<?php

namespace Catalog\Product\Domain\Services;

use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\ProductPriceSummary;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductPriceDiscountPercentage;
use Catalog\Shared\Domain\ValueObjects\Currency;

class MatchProductsDiscountsService
{
    private array $productDiscounts;

    /**
     * @param ProductDiscount[] $productDiscounts
     */
    public function __construct(ProductDiscount ...$productDiscounts)
    {
        $this->productDiscounts = array_map(function (ProductDiscount $discount){
            return $discount->toArray();
        }, $productDiscounts);
    }

    /**
     * @param Product[] $products
     * @return array
     */
    public function match(array $products): array {
        $matchProducts = [];

        foreach ($products as $product){
            $productArray = $product->toArray();
            $productArray['price'] = $this->matchProductBestDiscount($product)->toArray();
            $matchProducts[] = $productArray;
        }

        return $matchProducts;
    }

    /**
     * @param Product $product
     * @return ProductPriceSummary
     */
    private function matchProductBestDiscount(Product $product): ProductPriceSummary {
        $originalPriceValue = $product->price()->value();
        $finalPriceValue = $product->price()->value();
        $discountPercentaje = null;

        foreach ($this->productDiscounts as $discount){
            if($discount['sku'] === $product->sku()->value() || $discount['category'] === $product->category()->value() ){
                $provisionalFinalPrice = $originalPriceValue - ($originalPriceValue * ($discount['percentage']/100));
                if($finalPriceValue > $provisionalFinalPrice) {
                    $finalPriceValue = $provisionalFinalPrice;
                    $discountPercentaje = $discount['percentage'] . "%";
                }
            }
        }

        return new ProductPriceSummary (
            $product->price(),
            new ProductPrice($finalPriceValue),
            new Currency("EUR"),
            $discountPercentaje !== null ? new ProductPriceDiscountPercentage($discountPercentaje) : null
        );
    }
}