<?php

namespace Catalog\Product\Application\Commands\SaveProduct;

use Catalog\Product\Domain\Exceptions\ProductAlreadyExistByIdException;
use Catalog\Product\Domain\Exceptions\ProductAlreadyExistBySkuException;
use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductId;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

final readonly class SaveProductApplicationService
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function save(
        ProductId $productId,
        ProductSku $productSku,
        ProductName $productName,
        ProductCategory $productCategory,
        ProductPrice $productPrice
    ): void {
        $product = Product::create($productId, $productSku, $productName, $productCategory, $productPrice);

        if ($this->repository->getById($productId) !== null) {
            throw new ProductAlreadyExistByIdException($productId);
        }

        $this->ensureSkuIsAvailable($productSku);

        $this->repository->save($product);
    }

    private function ensureIdIsAvailable(ProductId $productId): void
    {
        if ($this->repository->getById($productId) !== null) {
            throw new ProductAlreadyExistByIdException($productId);
        }
    }
    private function ensureSkuIsAvailable(ProductSku $productSku): void
    {
        if ($this->repository->getBySku($productSku) !== null) {
            throw new ProductAlreadyExistBySkuException($productSku);
        }
    }
}


