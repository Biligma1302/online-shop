<?php

declare(strict_types=1);

namespace Request;

class UpdateProfileRequest
{
    public function __construct(private array $data)
    {
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

   public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (strlen($name) < 5) {
                $errors['name'] = 'Имя не может содержать меньше 5 символов';
            }
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];
            if (strlen($email) < 5) {
                $errors['email'] = "Email не может содержать меньше 5 сиволов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            }
        }
        return $errors;
    }
}