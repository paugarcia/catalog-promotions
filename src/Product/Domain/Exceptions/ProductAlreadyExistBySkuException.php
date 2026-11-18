<?php

namespace Catalog\Product\Domain\Exceptions;

use Catalog\Product\Domain\ValueObjects\ProductSku;

final class ProductAlreadyExistBySkuException extends \DomainException
{
    public const string MESSAGE_TEMPLATE = 'A product with sku %s already exists.';

    public function __construct(ProductSku $productSku)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $productSku->value()));
    }
}
