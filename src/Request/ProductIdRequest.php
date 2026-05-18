<?php

declare(strict_types=1);

namespace Request;

class ProductIdRequest
{
    public function __construct(private array $data)
    {
    }

    public function getProductId(): int
    {
        return (int) ($this->data['product_id'] ?? 0);
    }

    public function validateProductId(): array
    {
        $errors = [];
        if (isset($this->data['product_id'])) {
            $product_id = $this->data['product_id'];
        } else {
            $errors['product_id'] = 'id продукта должен быть обязательно указан';
        }
        return $errors;
    }
}