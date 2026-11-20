<?php

namespace App\Controller\Catalog\Product;

use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommand;
use Catalog\Product\Application\Commands\SaveProduct\SaveProductCommandHandler;
use Catalog\Product\Domain\Exceptions\ProductAlreadyExistByIdException;
use Catalog\Product\Domain\Exceptions\ProductAlreadyExistBySkuException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateProductController
{
    public function __invoke(string $productId, Request $request, SaveProductCommandHandler $handler): JsonResponse
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
}
