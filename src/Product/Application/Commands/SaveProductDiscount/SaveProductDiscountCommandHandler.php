<?php

namespace App\Product\Application\Commands\SaveProductDiscount;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\DiscountPercentage;
use App\Product\Domain\ValueObjects\ProductCategory;

use App\Product\Domain\ProductDiscount;

use App\Shared\Application\Command;
use App\Shared\Application\CommandHandler;

final class SaveProductDiscountCommandHandler implements CommandHandler
{
    private SaveProductDiscountApplicationService $saveProductDiscountApplicationService;

    public function __construct(SaveProductDiscountApplicationService $saveProductDiscountApplicationService)
    {
        $this->saveProductDiscountApplicationService = $saveProductDiscountApplicationService;
    }

    public function handle(Command $command): void
    {
        $discountPercentage = new DiscountPercentage($command->percentage());
        $productSku = new ProductSku($command->sku());
        $productCategory = new ProductCategory($command->category());

        $productDiscount = new ProductDiscount($discountPercentage, $productSku, $productCategory);

        $this->saveProductDiscountApplicationService->save($productDiscount);
    }
}

