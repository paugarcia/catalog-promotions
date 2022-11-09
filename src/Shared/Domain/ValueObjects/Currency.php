<?php

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidCurrencyException;

final class Currency
{
    private string $currency;

    private array $valid_currencies = ['EUR'];

    public function __construct(string $currency)
    {
        $this->validateCurrency($currency);
        $this->currency = $currency;
    }

    public function value(): string
    {
        return $this->currency;
    }

    private function validateCurrency(string $currency): void {
        if (!in_array($currency, $this->valid_currencies)) {
            throw new InvalidCurrencyException(
                sprintf("The currency %s, is not valid.", $currency)
            );
        }
    }
}