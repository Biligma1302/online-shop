<?php

namespace DTO;

class UserProductDTO
{
    public function __construct(
        private int $id,
        private int $user_id,
        private int $product_id,
        private int $amount,

        private string $name,
        private string $description,
        private float $price,
        private string $image_url
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}