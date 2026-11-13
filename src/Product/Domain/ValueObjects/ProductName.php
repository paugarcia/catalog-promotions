<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductNameException;

final class ProductName
{
    private readonly string $name;

    public function __construct(string $name)
    {
        $this->validateName($name);
        $this->name = $name;
    }

    public function value(): string
    {
        return $this->name;
    }

    private function validateName(string $name): void
    {
        if (trim($name) === '') {
            throw new InvalidProductNameException("Invalid product name, can't be empty.");
        }
    }
}
