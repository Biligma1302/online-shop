<?php

namespace Request;


class ProductIdRequest
{
    public function __construct(private array $data)
    {
    }

    public function getProductId(): int
    {
        return $this->data['product_id'];
    }

    public function addProductValidate(): array
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