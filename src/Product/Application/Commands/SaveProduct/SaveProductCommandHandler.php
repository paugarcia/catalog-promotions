<?php

namespace Catalog\Product\Application\Commands\SaveProduct;

use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductId;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;
use Catalog\Shared\Application\Command;
use Catalog\Shared\Application\CommandHandler;

final readonly class SaveProductCommandHandler implements CommandHandler
{
    public function __construct(private SaveProductApplicationService $saveProductApplicationService)
    {
    }

    public function handle(Command $command): void
    {
        $productId = new ProductId($command->productId());
        $productSku = new ProductSku($command->sku());
        $productName = new ProductName($command->name());
        $productCategory = new ProductCategory($command->category());
        $productPrice = new ProductPrice($command->price());

        $this->saveProductApplicationService->save(
            $productId,
            $productSku,
            $productName,
            $productCategory,
            $productPrice
        );
    }
}

