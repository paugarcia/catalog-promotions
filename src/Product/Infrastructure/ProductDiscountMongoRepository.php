<?php

namespace Catalog\Product\Infrastructure;

use Catalog\MongoDB\Client;
use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\Repository\ProductDiscountRepository;
use Catalog\Product\Domain\ValueObjects\DiscountPercentage;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductSku;

final class ProductDiscountMongoRepository implements ProductDiscountRepository
{
    public function __construct()
    {
        $user = getenv('MONGO_USERNAME');
        $pass = getenv('MONGO_PASSWORD');
        $host = getenv('MONGO_HOST');
        $db = getenv('MONGO_DATABASE');

        $this->mongo = new Client("mongodb://$user:$pass@$host");
        $this->collection = $this->mongo
            ->selectDatabase($db)
            ->selectCollection('discounts');
    }

    public function getAll(): array
    {
        $productDiscounts = $this->collection->find();
        $discountList = [];

        if (!empty($productDiscounts)) {
            foreach ($productDiscounts as $discount) {
                $discountList[] = ProductDiscount::create(
                    new DiscountPercentage($discount['percentage']),
                    new ProductSku($discount['sku']),
                    new ProductCategory($discount['category'])
                );
            }
        }

        return $discountList;
    }

    public function save(ProductDiscount $productDiscount): void
    {
        $this->collection->insertOne([
            'sku' => $productDiscount->productSku()->value(),
            'percentage' => $productDiscount->discountPercentage()->value(),
            'category' => $productDiscount->productCategory()->value(),
        ]);
    }
}