<?php

namespace Catalog\Product\Application\Queries\GetProductsWithDiscounts;

use Catalog\Product\Domain\Services\MatchProductsDiscountsService;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Shared\Application\QueryHandler;
use Catalog\Shared\Application\Query;

final readonly class GetProductsWithDiscountsQueryHandler implements QueryHandler
{
    public function __construct(
        private GetProductsWithDiscountsApplicationService $applicationService,
        private MatchProductsDiscountsService $matchProductsDiscountsService,
    )
    {
    }

    public function handle(Query $query): array
    {
        $response = [];
        if(null !== $query->filterCategory()){
            $productCategoryToFilter = new ProductCategory($query->filterCategory());
            $products = $this->applicationService->getAllProductsByCategory($productCategoryToFilter);
        }else{
            $products = $this->applicationService->getAllProducts();
        }

        $productsDiscounts = $this->applicationService->getAllDiscounts();

        if(!empty($products)){
            $response = ($this->matchProductsDiscountsService)($products, $productsDiscounts);
        }

        return $response;
    }



}
