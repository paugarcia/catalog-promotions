<?php

namespace App\Tests\Product\Infrastructure\Http;

use App\Kernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetProductByIdTest extends TestCase
{
    public function testReturnsProductForExistingId(): void
    {
        $response = $this->request('/api/products/10000000-0000-4000-8000-000000000001');

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame([
            'productId' => '10000000-0000-4000-8000-000000000001',
            'sku' => '000001',
            'name' => 'BV Lean leather ankle boots',
            'category' => 'boots',
            'price' => 89000,
        ], json_decode($response->getContent(), true));
    }

    public function testReturnsNotFoundForUnknownId(): void
    {
        self::assertSame(Response::HTTP_NOT_FOUND, $this->request('/api/products/10000000-0000-4000-8000-999999999999')->getStatusCode());
    }

    public function testReturnsBadRequestForInvalidId(): void
    {
        self::assertSame(Response::HTTP_BAD_REQUEST, $this->request('/api/products/invalid')->getStatusCode());
    }

    public function testOnlyAllowsGet(): void
    {
        self::assertSame(Response::HTTP_METHOD_NOT_ALLOWED, $this->request('/api/products/10000000-0000-4000-8000-000000000001', 'POST')->getStatusCode());
    }

    private function request(string $path, string $method = 'GET'): Response
    {
        $kernel = new Kernel('test', false);
        try {
            return $kernel->handle(Request::create($path, $method));
        } finally {
            $kernel->shutdown();
        }
    }
}
