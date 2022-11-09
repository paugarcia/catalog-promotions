<?php

namespace Catalog\Product\Application\Commands\SaveProduct;

use Catalog\Product\Domain\Exceptions\ProductAlreadyExistException;
use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

final class SaveProductApplicationService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function save(ProductSku $productSku, ProductName $productName, ProductCategory $productCategory, ProductPrice $productPrice): void
    {
        if (!empty($this->productRepository->getBySku($productSku))){
            throw new ProductAlreadyExistException(
                sprintf('Already exist a product with this sku: %s', $productSku->value())
            );
        }

        $product = new Product($productSku, $productName, $productCategory, $productPrice);

        $this->productRepository->save($product);
    }
}