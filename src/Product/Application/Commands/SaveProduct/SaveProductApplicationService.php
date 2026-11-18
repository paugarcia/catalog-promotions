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

        if ($this->isIdempotent($product)) {
            return;
        }

        $this->ensureSkuIsAvailable($productSku);

        $this->repository->save($product);
    }

    private function isIdempotent(Product $product): bool
    {
        $existingProduct = $this->repository->getById($product->productId());

        if ($existingProduct === null) {
            return false;
        }

        if (!$existingProduct->equals($product)) {
            throw new ProductAlreadyExistByIdException(
                sprintf(
                    'A product with id %s already exists with different data.',
                    $product->productId()->value()
                )
            );
        }

        return true;
    }

    private function ensureSkuIsAvailable(ProductSku $productSku): void
    {
        if ($this->repository->getBySku($productSku) !== null) {
            throw new ProductAlreadyExistBySkuException(
                sprintf('A product with sku %s already exists.', $productSku->value())
            );
        }
    }
}
