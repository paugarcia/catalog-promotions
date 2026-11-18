<?php

namespace Catalog\Shared\Domain\ValueObjects;

use Catalog\Shared\Domain\Exceptions\InvalidUuidException;

abstract readonly class Uuid
{
    public function __construct(private string $value)
    {
        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value) !== 1) {
            throw new InvalidUuidException(sprintf('Invalid UUID: "%s".', $value));
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
