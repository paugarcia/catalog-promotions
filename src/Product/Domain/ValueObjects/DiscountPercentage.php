<?php

namespace App\Product\Domain\ValueObjects;

use App\Product\Domain\Exceptions\InvalidDiscountPercentageException;

final class DiscountPercentage
{
    private int $percentage;

    public function __construct(int $percentage)
    {
        $this->validatePercentage($percentage);
        $this->percentage = $percentage;
    }

    public function value(): int
    {
        return $this->percentage;
    }

    public function toString(): string
    {
        return $this->percentage . "%";
    }

    private function validatePercentage($percentage): void
    {
        if ($percentage <= 0 || $percentage > 100){
            throw new InvalidDiscountPercentageException(
                sprintf("Invalid percentage (%s), must be more than 0 and less than 100.", $percentage)
            );
        }
    }
}