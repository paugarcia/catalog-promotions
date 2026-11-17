<?php

namespace Catalog\Product\Application\Commands\SaveProductDiscount;

use Catalog\Product\Domain\ProductDiscount;
use Catalog\Product\Domain\Repository\ProductDiscountRepository;

final readonly class SaveProductDiscountApplicationService
{
    public function __construct(private ProductDiscountRepository $productDiscountRepository)
    {
    }

    public function save(ProductDiscount $productDiscount): void
    {
        $this->productDiscountRepository->save($productDiscount);
    }
}
