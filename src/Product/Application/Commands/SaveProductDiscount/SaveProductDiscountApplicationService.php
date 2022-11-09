<?php

namespace Catalog\Product\Application\Commands\SaveProductDiscount;

use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\Repository\ProductDiscountRepository;

final class SaveProductDiscountApplicationService
{
    private ProductDiscountRepository $productDiscountRepository;

    public function __construct(ProductDiscountRepository $productDiscountRepository)
    {
        $this->productDiscountRepository = $productDiscountRepository;
    }

    public function save(ProductDiscount $productDiscount): void
    {
        $this->productDiscountRepository->save($productDiscount);
    }
}