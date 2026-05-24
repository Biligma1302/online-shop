<?php

declare(strict_types=1);

namespace DTO;

class ProductDTO
{
    public function __construct(
        private string $name,
        private string $description,
        private float $price,
        private string $imageUrl,
    ) {
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
        return $this->imageUrl;
    }
}