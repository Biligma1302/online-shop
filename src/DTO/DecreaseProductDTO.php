<?php

declare(strict_types=1);

namespace DTO;

class DecreaseProductDTO
{
    public function __construct(
        private int $product_id,
    ) {
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }
}