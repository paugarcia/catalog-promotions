<?php

namespace App\Product\Domain;

use App\Product\Domain\ValueObjects\ProductPrice;
use App\Product\Domain\ValueObjects\ProductPriceDiscountPercentage;
use App\Shared\Domain\ValueObjects\Currency;


final class ProductPriceSummary
{
    private ProductPrice $original;
    private ProductPrice $final;
    private ?ProductPriceDiscountPercentage $discountPercentage;
    private Currency $currency;

    public function __construct(ProductPrice $original, ProductPrice $final, Currency $currency, ?ProductPriceDiscountPercentage $discountPercentage)
    {
        $this->original = $original;
        $this->final = $final;
        $this->currency = $currency;
        $this->discountPercentage = $discountPercentage;
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

    public function discountPercentage(): ?ProductPriceDiscountPercentage
    {
        return $this->discountPercentage;
    }

    public function toArray(): array
    {
        return [
            'original' => $this->original->value(),
            'final' => $this->final->value(),
            'currency' => $this->currency->value(),
            'discount_percentage' => ($this->discountPercentage !== null) ? $this->discountPercentage->value() : $this->discountPercentage(),
        ];
    }
}