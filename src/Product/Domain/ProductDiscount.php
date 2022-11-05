<?php

namespace App\Product\Domain;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\DiscountPercentage;
use App\Product\Domain\ValueObjects\ProductCategory;

use App\Product\Domain\Exceptions\InvalidProductDiscountException;

final class ProductDiscount
{
    private DiscountPercentage $percentage;
    private ?ProductSku $sku;
    private ?ProductCategory $category;

    public function __construct(DiscountPercentage $percentage, ?ProductSku $sku, ?ProductCategory $category)
    {
        $this->sku = $sku;
        $this->percentage = $percentage;
        $this->category = $category;

        $this->validateParams();
    }

    public function sku(): ProductSku
    {
        return $this->sku;
    }

    public function percentage(): DiscountPercentage
    {
        return $this->percentage;
    }

    public function category(): ProductCategory
    {
        return $this->category;
    }

    private function validateParams(){
        if($this->sku === null && $this->category === null){
            throw new InvalidProductDiscountException(
                sprintf("ProductDiscount not created - Invalid sku and category")
            );
        }
    }
}