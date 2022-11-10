<?php

namespace App\Tests\Shared\Domain\ValueObjects;

use Catalog\Shared\Domain\ValueObjects\Currency;
use Catalog\Shared\Domain\Exceptions\InvalidCurrencyException;
use Catalog\Shared\Domain\Exceptions\InvalidEmptyCurrencyException;

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testCurrencyShouldBeCreated(): void
    {
        $currencyValue = "EUR";
        $currency = new Currency($currencyValue);

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertEquals($currencyValue, $currency->value());
    }

    public function testCurrencyWithoutValueShouldNotBeCreated(): void
    {
        $currencyValue = "";
        $this->expectException(InvalidEmptyCurrencyException::class);

        new Currency($currencyValue);
    }

    public function testCurrencyWithNotValidCurrencyShouldNotBeCreated():void
    {
        $currencyValue = "USD";
        $this->expectException(InvalidCurrencyException::class);

        new Currency($currencyValue);
    }
}