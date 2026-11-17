<?php

namespace Catalog\Product\Application\Queries\GetProductsWithDiscounts;

use Catalog\Product\Domain\Repository\ProductDiscountRepository;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductCategory;

final readonly class GetProductsWithDiscountsApplicationService
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductDiscountRepository $productDiscountRepository,
    )
    {
    }

    public function getAllProducts(): array
    {
        return $this->productRepository->getAll();
    }

    public function getAllProductsByCategory(ProductCategory $productCategory): array
    {
        return $this->productRepository->getByProductCategory($productCategory);
    }

    public function getAllDiscounts(): array
    {
        return $this->productDiscountRepository->getAll();
    }
}
