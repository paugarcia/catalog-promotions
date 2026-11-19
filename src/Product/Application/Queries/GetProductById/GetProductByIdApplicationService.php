<?php

namespace Catalog\Product\Application\Queries\GetProductById;

use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductId;

final readonly class GetProductByIdApplicationService
{
    public function __construct(private ProductRepository $repository)
    {
    }

    public function getById(ProductId $productId): ?Product
    {
        return $this->repository->getById($productId);
    }
}
