<?php

namespace Catalog\Product\Domain\ValueObjects;

use Catalog\Product\Domain\Exceptions\InvalidDiscountPercentageException;

final readonly class DiscountPercentage
{
    public const MIN_PERCENTAGE = 1;
    public const MAX_PERCENTAGE = 100;

    public function __construct(private int $percentage)
    {
        $this->validatePercentage($percentage);
    }

    public function value(): int
    {
        return $this->percentage;
    }

    public function __toString(): string
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
