<?php

namespace Catalog\Product\Application\Commands\SaveProductDiscount;

use Catalog\Shared\Application\Command;

final readonly class SaveProductDiscountCommand implements Command
{
    public function __construct(
        private int $percentage,
        private ?string $sku,
        private ?string $category,
    )
    {
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
