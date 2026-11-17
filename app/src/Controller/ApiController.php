<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQuery;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQueryHandler;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsApplicationService;
use Catalog\Product\Domain\Services\MatchProductsDiscountsService;

use Catalog\Product\Infrastructure\Persistence\Memory\ProductInMemoryRepository;
use Catalog\Product\Infrastructure\Persistence\Memory\ProductDiscountInMemoryRepository;


class ApiController extends AbstractController
{
    public function index(Request $request): JsonResponse
    {
        $productRepository = new ProductInMemoryRepository();
        $productDiscountRepository = new ProductDiscountInMemoryRepository();

        $query = new GetProductsWithDiscountsQuery($request->query->get('filterByCategory'));
        $queryHandler = new GetProductsWithDiscountsQueryHandler(
            new GetProductsWithDiscountsApplicationService($productRepository, $productDiscountRepository),
            new MatchProductsDiscountsService(),
        );

        try {
            $productsWithDiscounts = $queryHandler->handle($query);
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => '[Error] ' . $e->getMessage()],
                400
            );
        }

        if (empty($productsWithDiscounts)) {
            return new JsonResponse(
                ['message' => 'Not found products.'],
                404
            );
        }

        return new JsonResponse(
            $productsWithDiscounts,
            Response::HTTP_OK
        );
    }
}
