<?php

namespace DTO;

use Model\User;

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