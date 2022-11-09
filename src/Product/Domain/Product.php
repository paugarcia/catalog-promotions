<?php

namespace App\Product\Domain;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\ProductName;
use App\Product\Domain\ValueObjects\ProductPrice;
use App\Product\Domain\ValueObjects\ProductCategory;

final class Product
{
    private ProductSku $sku;
    private ProductName $name;
    private ProductCategory $category;
    private ProductPrice $price;

    public function __construct(ProductSku $sku, ProductName $name, ProductCategory $category, ProductPrice $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public function sku(): ProductSku
    {
        return $this->sku;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function category(): ProductCategory
    {
        return $this->category;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku->value(),
            'name' => $this->name->value(),
            'category' => $this->category->value(),
            'price' => $this->price->value()
        ];
    }
}