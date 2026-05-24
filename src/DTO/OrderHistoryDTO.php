<?php

declare(strict_types=1);

namespace DTO;

class OrderHistoryDTO
{
    public function __construct(
        private int $order_id,
        private string $contact_name,
        private string $contact_phone,
        private string $address,
        private string $comment,
        private string $product_name,
        private float $price,
        private int $amount,
        private string $image_url,
    ) {
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getProductName(): string
    {
        return $this->product_name;
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
        return $this->image_url;
    }

    public function getTotalSum(): float
    {
        return $this->price * $this->amount;
    }
}