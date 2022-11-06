<?php

namespace App\Product\Infrastructure;

use App\Product\Domain\Repository\ProductRepository;
use App\Product\Domain\Product;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\ProductCategory;

use MongoDB\Client;

final class ProductMongoRepository implements ProductRepository
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
            ->selectCollection('products');
    }
    
    public function getAll(): array
    {
        $products = $this->collection->find();
        
        if (!empty($products)) {
            foreach ($products as $product) {
                var_dump($products);
            };
        }

        die;

        return [];
    }

    public function save(Product $product): void
    {
        $this->collection->insertOne([
            'sku' => $product->sku()->value(),
            'name' => $product->name()->value(),
            'category' => $product->category()->value(),
            'price' => $product->price()->value()
        ]);
    }

    // TODO: Develop "getBySku" function
    public function getBySku(ProductSku $sku): ?Product
    {
        return null;    
    }

    // TODO: Develop "getByProductCategory" function
    public function getByProductCategory(ProductCategory $category): array
    {
        return [];
    }

}