<?php

namespace Catalog\Product\Application\Queries\GetProductById;

use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\ValueObjects\ProductId;
use Catalog\Shared\Application\QueryHandler;

final readonly class GetProductByIdQueryHandler implements QueryHandler
{
    public function __construct(private GetProductByIdApplicationService $applicationService)
    {
    }

    public function handle(GetProductByIdQuery $query): ?Product
    {
        return $this->applicationService->getById(new ProductId($query->productId()));
    }
}
