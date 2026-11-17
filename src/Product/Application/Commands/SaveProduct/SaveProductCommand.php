<?php

namespace Catalog\Product\Application\Commands\SaveProduct;

use Catalog\Shared\Application\Command;

final readonly class SaveProductCommand implements Command
{
    public function __construct(
        private string $sku,
        private string $name,
        private string $category,
        private int $price,
    )
    {
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
