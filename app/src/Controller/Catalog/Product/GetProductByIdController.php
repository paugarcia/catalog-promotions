<?php

namespace App\Controller\Catalog\Product;

use Catalog\Product\Application\Queries\GetProductById\GetProductByIdQuery;
use Catalog\Product\Application\Queries\GetProductById\GetProductByIdQueryHandler;
use Catalog\Shared\Domain\Exceptions\InvalidUuidException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetProductByIdController
{
    public function __invoke(string $productId, GetProductByIdQueryHandler $getProductById): JsonResponse
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

}
