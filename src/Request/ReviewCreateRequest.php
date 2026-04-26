<?php

namespace Request;

class ReviewCreateRequest
{
public function __construct(private array $data) {
}

public function getProductId(): int
{
    return $this->data['product_id'];
}
public function getRating(): int
{
    return $this->data['rating'];
}
public function getComment(): string
{
    return $this->data['comment'];
}

    public function validate(): array
    {
        $errors = [];
        if (empty($this->data['product_id'])) $errors['product_id'] = 'ID товара обязателен';
        if (empty($this->data['comment'])) $errors['comment'] = 'Напишите отзыв';
        if (empty($this->data['rating'])) $errors['rating'] = 'Поставьте оценку';

        return $errors;
    }
}