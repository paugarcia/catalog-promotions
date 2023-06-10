<?php

namespace Catalog\Product\Domain;

use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductPriceDiscountPercentage;
use Catalog\Shared\Domain\ValueObjects\Currency;


final class ProductPriceSummary
{
    public function __construct(
        private readonly ProductPrice $original,
        private readonly ProductPrice $final,
        private readonly Currency $currency,
        private readonly ?ProductPriceDiscountPercentage $discountPercentage
    ) {
    }

    public static function create(
        ProductPrice $original,
        ProductPrice $final,
        Currency $currency,
        ?ProductPriceDiscountPercentage $discountPercentage
    ): self {
        return new self($original, $final, $currency, $discountPercentage);
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
            'discount_percentage' => ($this->discountPercentage !== null) ? $this->discountPercentage->value(
            ) : $this->discountPercentage(),
        ];
    }
}