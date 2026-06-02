<?php

declare(strict_types=1);

namespace DTO;

class OrderProductDTO
{
    public function __construct(
        private string $productName,
        private float $price,
        private int $amount,
        private string $imageUrl,
    ) {
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getTotalSum(): float
    {
        return $this->price * $this->amount;
    }
}