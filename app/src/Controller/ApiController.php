<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommand;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommandHandler;
use Catalog\Product\Domain\Exceptions\ProductAlreadyExistByIdException;
use Catalog\Product\Domain\Exceptions\ProductAlreadyExistBySkuException;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQuery;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQueryHandler;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsApplicationService;
use Catalog\Product\Domain\Services\MatchProductsDiscountsService;
use Catalog\Product\Application\Queries\GetProductById\GetProductByIdQuery;
use Catalog\Product\Application\Queries\GetProductById\GetProductByIdQueryHandler;
use Catalog\Shared\Domain\Exceptions\InvalidUuidException;

use Catalog\Product\Infrastructure\Persistence\Memory\ProductInMemoryRepository;
use Catalog\Product\Infrastructure\Persistence\Memory\ProductDiscountInMemoryRepository;


class ApiController extends AbstractController
{
    public function createProduct(string $productId, Request $request, SaveProductCommandHandler $handler): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return new JsonResponse(['message' => 'Invalid JSON body.'], Response::HTTP_BAD_REQUEST);
        }

        if (!is_array($data) || !isset($data['sku'], $data['name'], $data['category'], $data['price'])
            || !is_string($data['sku']) || !is_string($data['name']) || !is_string($data['category'])
            || !is_int($data['price'])) {
            return new JsonResponse(['message' => 'Expected sku, name and category as strings and price as an integer.'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $handler->handle(new SaveProductCommand($productId, $data['sku'], $data['name'], $data['category'], $data['price']));
        } catch (ProductAlreadyExistByIdException | ProductAlreadyExistBySkuException $e) {
            return new JsonResponse(['message' => '[Error] ' . $e->getMessage()], Response::HTTP_CONFLICT);
        } catch (\DomainException $e) {
            return new JsonResponse(['message' => '[Error] ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(null, Response::HTTP_CREATED, ['Location' => '/api/products/' . $productId]);
    }
    public function getProduct(string $productId, GetProductByIdQueryHandler $getProductById): JsonResponse
    {
        try {
            $product = $getProductById->handle(new GetProductByIdQuery($productId));
        } catch (InvalidUuidException $e) {
            return new JsonResponse(['message' => '[Error] ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        if ($product === null) {
            return new JsonResponse(['message' => 'Product not found.'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($product->toArray(), Response::HTTP_OK);
    }

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
 

