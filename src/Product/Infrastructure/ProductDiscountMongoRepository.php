<?php

namespace App\Product\Infrastructure;

use App\Product\Domain\Repository\ProductDiscountRepository;

use App\Product\Domain\ProductDiscount;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\DiscountPercentage;
use App\Product\Domain\ValueObjects\ProductCategory;

use MongoDB\Client;

final class ProductDiscountMongoRepository implements ProductDiscountRepository
{

    public function __construct()
    {
        $user = getenv('MONGO_USERNAME');
        $pass = getenv('MONGO_PASSWORD');
        $host = getenv('MONGO_HOST');
        $db   = getenv('MONGO_DATABASE');

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
                $discountList[] = new ProductDiscount(
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
            'sku' => $productDiscount->sku()->value(),
            'percentage' => $productDiscount->percentage()->value(),
            'category' => $productDiscount->category()->value(),
        ]);
    }
}