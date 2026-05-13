<?php

namespace Request;

class LoginRequest
{
    public function __construct(private array $data)
    {
    }

    public function getUsername()
    {
        return $this->data['username'];
    }

    public function getPassword()
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