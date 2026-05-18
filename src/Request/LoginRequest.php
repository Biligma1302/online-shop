<?php

declare(strict_types=1);

namespace Request;

class LoginRequest
{
    public function __construct(private array $data)
    {
    }

    public function getUsername(): string
    {
        return $this->data['username'];
    }

    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function validate(): array
    {
        $errors = [];

        if (empty($this->data['username'])) {
            $errors['username'] = 'Поле Username обязательно для заполнения!';
        }
        if (empty($this->data['password'])) {
            $errors['password'] = 'Поле Password обязательно для заполнения!';
        }
        return $errors;
    }
}