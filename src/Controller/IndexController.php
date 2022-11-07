<?php

namespace App\Controller;

use App\Product\Domain\ValueObjects\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use App\Product\Infrastructure\ProductInMemoryRepository;


class IndexController extends AbstractController
{
    // http://localhost:33000/index?filterByCategory=boots (GET PRODUCTS FILTER BY CATEGORY)
    // http://localhost:33000/index (GET ALL PRODUCTS)
    public function index(Request $request) : Response
    {
        $productInMemoryRepository = new ProductInMemoryRepository();
        if($request->query->get('filterByCategory') !== null){
            $productCategoryToFind = new ProductCategory($request->query->get('filterByCategory'));
            $products = $productInMemoryRepository->getByProductCategory($productCategoryToFind);
        }else{
            $products = $productInMemoryRepository->getAll();
        }

        return new JsonResponse($products);
    }
}