<?php

namespace Catalog\Product\Application\Commands\SaveProduct;

use Catalog\Product\Domain\Exceptions\ProductAlreadyExistException;
use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

final readonly class SaveProductApplicationService
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function save(
        ProductSku $productSku,
        ProductName $productName,
        ProductCategory $productCategory,
        ProductPrice $productPrice
    ): void {
        if (!empty($this->repository->getBySku($productSku))) {
            throw new ProductAlreadyExistException(
                sprintf('Already exist a product with this sku: %s', $productSku->value())
            );
        }

        $product = Product::create($productSku, $productName, $productCategory, $productPrice);

        $this->repository->save($product);
    }
}
