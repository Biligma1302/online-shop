<?php

declare(strict_types=1);

namespace DTO;

class UserProductDTO
{
    private ?ProductDTO $product = null;
    public function __construct(
        private int $id,
        private int $userId,
        private int $productId,
        private int $amount,
    ) {
    }

    public function setProduct(ProductDTO $product): void
    {
        $this->product = $product;
    }

    public function getProduct(): ?ProductDTO
    {
        return $this->product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}