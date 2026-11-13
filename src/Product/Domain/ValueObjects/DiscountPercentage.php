<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidDiscountPercentageException;

final class DiscountPercentage
{
    public const MIN_PERCENTAGE = 1;
    public const MAX_PERCENTAGE = 100;

    private readonly int $percentage;

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

    private function validatePercentage(int $percentage): void
    {
        if ($percentage < self::MIN_PERCENTAGE || $percentage > self::MAX_PERCENTAGE) {
            throw new InvalidDiscountPercentageException(
                sprintf(
                    "Invalid percentage (%s), must be between %d and %d.",
                    $percentage,
                    self::MIN_PERCENTAGE,
                    self::MAX_PERCENTAGE
                )
            );
        }
    }
}
