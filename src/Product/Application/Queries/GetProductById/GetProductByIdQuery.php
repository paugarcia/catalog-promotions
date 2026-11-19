<?php

namespace Catalog\Product\Application\Queries\GetProductById;

use Catalog\Shared\Application\Query;

final readonly class GetProductByIdQuery implements Query
{
    public function __construct(private string $productId)
    {
    }

    public function productId(): string
    {
        return $this->productId;
    }
}
