<?php

namespace Catalog\Product\Application\Queries\GetProductsWithDiscounts;

use Catalog\Shared\Application\Query;

final readonly class GetProductsWithDiscountsQuery implements Query
{
    public function __construct(private ?string $filterCategory)
    {
    }

    public function filterCategory(): ?string
    {
        return $this->filterCategory;
    }
}
