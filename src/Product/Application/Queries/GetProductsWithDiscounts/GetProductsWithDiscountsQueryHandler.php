<?php

namespace Catalog\Product\Application\Queries\GetProductsWithDiscounts;

use Catalog\Product\Domain\Services\MatchProductsDiscountsService;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Shared\Application\QueryHandler;
use Catalog\Shared\Application\Query;

final class GetProductsWithDiscountsQueryHandler implements QueryHandler
{
    private GetProductsWithDiscountsApplicationService $applicationService;

    public function __construct(GetProductsWithDiscountsApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
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
            $matchProductsDiscountsService = new MatchProductsDiscountsService();
            $response = $matchProductsDiscountsService->__invoke($products, $productsDiscounts);
        }

        return $response;
    }



}