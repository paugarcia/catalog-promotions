<?php

namespace App\Product\Application\Commands\SaveProduct;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\ProductName;
use App\Product\Domain\ValueObjects\ProductPrice;
use App\Product\Domain\ValueObjects\ProductCategory;

use App\Shared\Application\Command;
use App\Shared\Application\CommandHandler;

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

