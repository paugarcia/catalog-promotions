<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductNameException;

final class ProductName
{
    private string $name;

    public function __construct(string $name)
    {
        $this->validateName($name);
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }

    private function validateName($name): void
    {
        if (empty($name)){
            throw new InvalidProductNameException(sprintf("Invalid product name, can't be empty."));
        }
    }
}