<?php

namespace App\Tests\Product\Infrastructure\Http;

use App\Kernel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetProductsWithDiscountsTest extends TestCase
{
    public function testReturnsProductsThroughTheHttpRoute(): void
    {
        $kernel = new Kernel('test', true);
        try {
            $response = $kernel->handle(Request::create('/api/products-with-discounts?filterByCategory=boots', 'GET'));
            self::assertSame(Response::HTTP_OK, $response->getStatusCode());
            self::assertNotEmpty(json_decode($response->getContent(), true));
        } finally {
            $kernel->shutdown();
        }
    }

    public function testRejectsPost(): void
    {
        $kernel = new Kernel('test', true);
        try {
            $response = $kernel->handle(Request::create('/api/products-with-discounts', 'POST'));
            self::assertSame(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());
        } finally {
            $kernel->shutdown();
        }
    }
}
