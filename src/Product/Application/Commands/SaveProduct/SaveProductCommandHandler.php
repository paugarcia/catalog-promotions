<?php

namespace Catalog\Product\Application\Commands\SaveProduct;

use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;
use Catalog\Shared\Application\Command;
use Catalog\Shared\Application\CommandHandler;

final class SaveProductCommandHandler implements CommandHandler
{
    private SaveProductApplicationService $saveProductApplicationService;

    public function __construct(SaveProductApplicationService $saveProductApplicationService)
    {
        $this->saveProductApplicationService = $saveProductApplicationService;
    }

    public function handle(Command $command): void
    {
        $productSku = new ProductSku($command->sku());
        $productName = new ProductName($command->name());
        $productCategory = new ProductCategory($command->category());
        $productPrice = new ProductPrice($command->price());

        $this->saveProductApplicationService->save($productSku, $productName, $productCategory, $productPrice);
    }
}

