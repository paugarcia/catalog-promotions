<?php

namespace App\Product\Domain\Services;

use App\Product\Domain\Product;
use App\Product\Domain\ProductDiscount;
use App\Product\Domain\ProductPriceSummary;
use App\Product\Domain\ValueObjects\ProductPrice;
use App\Product\Domain\ValueObjects\ProductPriceDiscountPercentage;
use App\Shared\Domain\ValueObjects\Currency;

class MatchProductsDiscountsService
{
    private array $productDiscounts;

    /**
     * @param ProductDiscount[] $productDiscounts
     */
    public function __construct(array $productDiscounts)
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