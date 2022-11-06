<?php

namespace App\Product\Application\Commands\SaveProductDiscount;

use App\Shared\Application\Command;

final class SaveProductDiscountCommand implements Command
{
    private int $percentage;
    private ?string $sku;
    private ?string $category;
    
    public function __construct(int $percentage, ?string $sku, ?string $category)
    {
        $this->percentage = $percentage;
        $this->sku = $sku;
        $this->category = $category;
    }

    public function percentage(): int
    {
        return $this->percentage;
    }

    public function sku(): ?string
    {
        return $this->sku;
    }

    public function category(): ?string
    {
        return $this->category;
    }
}