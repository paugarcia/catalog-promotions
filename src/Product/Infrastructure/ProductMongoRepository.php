<?php

namespace Catalog\Product\Infrastructure;

use Catalog\MongoDB\Client;
use Catalog\Product\Domain\Product;
use Catalog\Product\Domain\Repository\ProductRepository;
use Catalog\Product\Domain\ValueObjects\ProductCategory;
use Catalog\Product\Domain\ValueObjects\ProductName;
use Catalog\Product\Domain\ValueObjects\ProductPrice;
use Catalog\Product\Domain\ValueObjects\ProductSku;

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
        $productsList = [];
        
        if (!empty($products)) {
            foreach ($products as $product) {
                $productsList[] = Product::create(
                    new ProductSku($product['sku']),
                    new ProductName($product['name']),
                    new ProductCategory($product['category']),
                    new ProductPrice($product['price']),
                );
            }
        }

        return $productsList;
    }

    public function save(Product $product): void
    {
        $this->collection->insertOne([
            'sku' => $product->productSku()->value(),
            'name' => $product->productName()->value(),
            'category' => $product->productCategory()->value(),
            'price' => $product->productPrice()->value()
        ]);
    }

    public function getBySku(ProductSku $sku): ?Product
    {
        $product = null;
        $item = $this->collection->findOne([
            'sku' => $sku->value()
        ]);

        if (!empty($item)) {
            $product = Product::create(
                new ProductSku($item['sku']),
                new ProductName($item['name']),
                new ProductCategory($item['category']),
                new ProductPrice($product['price'])
            );
        }

        return $product;
    }

    // TODO: Develop "getByProductCategory" function
    public function getByProductCategory(ProductCategory $category): array
    {
        return [];
    }

}