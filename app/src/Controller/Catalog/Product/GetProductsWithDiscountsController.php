<?php

namespace App\Controller\Catalog\Product;

use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQuery;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetProductsWithDiscountsController
{
    public function __invoke(Request $request, GetProductsWithDiscountsQueryHandler $queryHandler): JsonResponse
    {
        $query = new GetProductsWithDiscountsQuery($request->query->get('filterByCategory'));

        try {
            $productsWithDiscounts = $queryHandler->handle($query);
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => '[Error] ' . $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }

        if (empty($productsWithDiscounts)) {
            return new JsonResponse(
                ['message' => 'Not found products.'],
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            $productsWithDiscounts,
            Response::HTTP_OK
        );
    }
}
