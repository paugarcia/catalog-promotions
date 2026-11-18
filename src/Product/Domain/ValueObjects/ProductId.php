<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductIdException;

final readonly class ProductId
{
    public function __construct(private string $id)
    {
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $id) !== 1) {
            throw new InvalidProductIdException(sprintf('Invalid product id: "%s".', $id));
        }
    }

    public function value(): string
    {
        return $this->id;
    }
}
