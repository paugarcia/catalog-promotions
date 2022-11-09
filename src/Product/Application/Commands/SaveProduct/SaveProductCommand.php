<?php

namespace Catalog\Product\Application\Commands\SaveProduct;

use Catalog\Shared\Application\Command;

final class SaveProductCommand implements Command
{
    private string $sku;
    private string $name;
    private string $category;
    private int $price;
    
    public function __construct(string $sku, string $name, string $category, int $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function price(): int
    {
        return $this->price;
    }
}