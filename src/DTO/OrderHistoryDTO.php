<?php

declare(strict_types=1);

namespace DTO;

class OrderHistoryDTO
{
    private array $products = [];
    public function __construct(
        private int $orderId,
        private string $contactName,
        private string $contactPhone,
        private string $address,
        private string $comment,
    ) {
    }

    public function addProduct(OrderProductDTO $product): void
    {
    $this->products[] = $product;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}