<?php

namespace Catalog\Product\Application\Commands\SaveProductDiscount;

use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\ValueObjects\DiscountPercentage;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductSku;
use Catalog\Shared\Application\Command;
use Catalog\Shared\Application\CommandHandler;

final readonly class SaveProductDiscountCommandHandler implements CommandHandler
{
    public function __construct(private SaveProductDiscountApplicationService $saveProductDiscountApplicationService)
    {
    }

    public function handle(Command $command): void
    {
        $discountPercentage = new DiscountPercentage($command->percentage());
        $productSku = $command->sku() !== null ? new ProductSku($command->sku()) : null;
        $productCategory = $command->category() !== null ? new ProductCategory($command->category()) : null;

        $productDiscount = ProductDiscount::create($discountPercentage, $productSku, $productCategory);

        $this->saveProductDiscountApplicationService->save($productDiscount);
    }
}

