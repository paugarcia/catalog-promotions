<?php

namespace App\Tests\Product\Application\Queries;


use App\Tests\Shared\TestInfrastructure\CatalogTest;

use Catalog\Product\Infrastructure\ProductDiscountInMemoryRepository;
use Catalog\Product\Infrastructure\ProductInMemoryRepository;

use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsApplicationService;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQuery;
use Catalog\Product\Application\Queries\GetProductsWithDiscounts\GetProductsWithDiscountsQueryHandler;


class GetProductsWithDiscountsBehaviourTest extends CatalogTest
{
    private ProductInMemoryRepository $productRepository;
    private ProductDiscountInMemoryRepository $productDiscountRepository;

    protected function setUp(): void
    {
        $this->productRepository = new ProductInMemoryRepository();
        $this->productDiscountRepository = new ProductDiscountInMemoryRepository();
        parent::setUp();
    }

    public function testGetAllProductsWithDiscounts(): void
    {
        $query = new GetProductsWithDiscountsQuery(null);
        $queryHandler = new GetProductsWithDiscountsQueryHandler(
            new GetProductsWithDiscountsApplicationService(
                $this->productRepository,
                $this->productDiscountRepository
            )
        );

        $productsWithDiscounts = $queryHandler->handle($query);

        self::assertCount(5, $productsWithDiscounts);
    }

}