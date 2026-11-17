<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidProductNameException;

final readonly class ProductName
{
    public function __construct(private string $name)
    {
        $this->validateName($name);
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
