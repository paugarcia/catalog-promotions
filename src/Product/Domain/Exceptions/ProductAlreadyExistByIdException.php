<?php

namespace Catalog\Product\Domain\Exceptions;

use Catalog\Product\Domain\ValueObjects\ProductId;

final class ProductAlreadyExistByIdException extends \DomainException
{
    public const string MESSAGE_TEMPLATE = 'A product with id %s already exists with different data.';

    public function __construct(ProductId $productId)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $productId->value()));
    }
}
