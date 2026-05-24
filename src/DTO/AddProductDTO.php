<?php

declare(strict_types=1);

namespace DTO;

class AddProductDTO
{
    public function __construct(
        private int $product_id,
        private int $amount,
    ) {
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}