<?php

namespace App\Tests\Shared\Domain\ValueObjects;

use Catalog\Shared\Domain\ValueObjects\Currency;

use App\Tests\Shared\TestInfrastructure\CatalogTest;

class CurrencyTest extends CatalogTest
{
    public function testCurrencyShouldBeCreated(): void
    {
        $currency = Currency::EUR;

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame('EUR', $currency->value);
    }

    public function testCurrencyWithoutValueShouldNotBeCreated(): void
    {
        $this->assertNull(Currency::tryFrom(''));
    }

    public function testCurrencyWithNotValidCurrencyShouldNotBeCreated():void
    {
        $this->assertNull(Currency::tryFrom('USD'));
    }
}
