<?php

namespace App\Product\Domain;

use App\Product\Domain\ValueObjects\ProductPrice;
use App\Product\Domain\ValueObjects\ProductPriceDiscountPercentage;
use App\Shared\Domain\ValueObjects\Currency;


final class ProductPriceSummary
{
    private ProductPrice $original;
    private ProductPrice $final;
    private ?ProductPriceDiscountPercentage $productPriceDiscountPercentage;
    private Currency $currency;

    public function __construct(ProductPrice $original, ProductPrice $final, Currency $currency, ?ProductPriceDiscountPercentage $productPriceDiscountPercentage)
    {
        $this->original = $original;
        $this->final = $final;
        $this->currency = $currency;
        $this->productPriceDiscountPercentage = $productPriceDiscountPercentage;
    }

    public function original(): ProductPrice
    {
        return $this->original;
    }

    public function final(): ProductPrice
    {
        return $this->final;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function productPriceDiscountPercentage(): ?ProductPriceDiscountPercentage
    {
        return $this->productPriceDiscountPercentage;
    }

    public function toArray(): array
    {
        return [
            'original' => $this->original->value(),
            'final' => $this->final->value(),
            'currency' => $this->currency->value(),
            'productPriceDiscountPercentage' => $this->productPriceDiscountPercentage->value(),
        ];
    }
}