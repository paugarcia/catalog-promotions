<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Product\Domain\Services\MatchProductsDiscountsService;
use App\Product\Domain\ValueObjects\ProductCategory;

use App\Product\Infrastructure\ProductDiscountInMemoryRepository;
use App\Product\Infrastructure\ProductInMemoryRepository;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ApiController extends AbstractController
{
    public function index(Request $request) : JsonResponse
    {
        $productInMemoryRepository = new ProductInMemoryRepository();

        if($request->query->get('filterByCategory') !== null) {
            $productCategoryToFind = new ProductCategory($request->query->get('filterByCategory'));
            $products = $productInMemoryRepository->getByProductCategory($productCategoryToFind);
        } else {
            $products = $productInMemoryRepository->getAll();
        }

        $productDiscountInMemoryRepository = new ProductDiscountInMemoryRepository();
        $matchProductsDiscountsService = new MatchProductsDiscountsService($productDiscountInMemoryRepository->getAll());

        return new JsonResponse($matchProductsDiscountsService->match($products), 200, []);
    }
}