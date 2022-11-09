<?php

namespace App\Controller;

use Catalog\Product\Domain\Services\MatchProductsDiscountsService;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Infrastructure\ProductDiscountInMemoryRepository;
use Catalog\Product\Infrastructure\ProductInMemoryRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ApiController extends AbstractController
{
    public function index(
        Request $request,
        ProductInMemoryRepository $productInMemoryRepository,
        ProductDiscountInMemoryRepository  $productDiscountInMemoryRepository
    ) : JsonResponse
    {
        if($request->query->get('filterByCategory') !== null) {
            $productCategoryToFind = new ProductCategory($request->query->get('filterByCategory'));
            $products = $productInMemoryRepository->getByProductCategory($productCategoryToFind);
        } else {
            $products = $productInMemoryRepository->getAll();
        }

        $matchProductsDiscountsService = new MatchProductsDiscountsService($productDiscountInMemoryRepository->getAll());

        return new JsonResponse($matchProductsDiscountsService->match($products), 200, []);
    }
}