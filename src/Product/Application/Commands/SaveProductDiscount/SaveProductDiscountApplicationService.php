<?php

namespace App\Product\Application\Commands\SaveProductDiscount;

use App\Product\Domain\ProductDiscount;

use App\Product\Domain\Repository\ProductDiscountRepository;

use App\Product\Domain\ValueObjects\ProductSku;
use App\Product\Domain\ValueObjects\DiscountPercentage;
use App\Product\Domain\ValueObjects\ProductCategory;

final class SaveProductDiscountApplicationService
{
    private ProductDiscountRepository $productDiscountRepository;

    public function __construct(ProductDiscountRepository $productDiscountRepository)
    {
        $this->productDiscountRepository = $productDiscountRepository;
    }

    public function save(ProductDiscount $productDiscount)
    {
        $this->productDiscountRepository->save($productDiscount);
    }
}