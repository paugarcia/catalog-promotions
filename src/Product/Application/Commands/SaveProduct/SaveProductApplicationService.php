<?php

namespace App\Product\Application\Commands\SaveProduct;

use App\Product\Domain\Product;

use App\Product\Domain\Repository\ProductRepository;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\ProductName;
use App\Product\Domain\ValueObjects\ProductPrice;
use App\Product\Domain\ValueObjects\ProductCategory;

use App\Product\Domain\Exceptions\ProductAlreadyExistException;

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