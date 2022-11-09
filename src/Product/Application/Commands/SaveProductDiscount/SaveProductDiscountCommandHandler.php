<?php

namespace Catalog\Product\Application\Commands\SaveProductDiscount;

use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\ValueObjects\DiscountPercentage;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductSku;
use Catalog\Shared\Application\Command;
use Catalog\Shared\Application\CommandHandler;

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
        $productSku = ($command->sku() != null) ? new ProductSku($command->sku()) : null;
        $productCategory = ($command->category() != null) ? new ProductCategory($command->category()) : null;

        $productDiscount = new ProductDiscount($discountPercentage, $productSku, $productCategory);

        $this->saveProductDiscountApplicationService->save($productDiscount);
    }
}

