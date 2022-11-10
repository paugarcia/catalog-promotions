<?php

namespace Catalog\Product\Application\Queries\GetProductsWithDiscounts;

use Catalog\Shared\Application\Query;

final class GetProductsWithDiscountsQuery implements Query
{
    private ?string $filterCategory;

    public function __construct(?string $filterCategory)
    {
        $this->filterCategory = $filterCategory;
    }

    public function filterCategory(): ?string
    {
        return $this->filterCategory;
    }
}