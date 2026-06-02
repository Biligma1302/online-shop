<?php

declare(strict_types=1);

namespace Request;

class RegistrationRequest
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

    public function getPsw(): string
    {
        return $this->data['psw'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];

            if (strlen($name) < 5) {
                $errors['name'] = 'Имя должно содержать минимум 5 символов';
            }
        } else {
            $errors['name'] = 'Имя должно быть заполнено';
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            if (strlen($email) < 5) {
                $errors['email'] = 'email указан некорректно';
            }
            if (strpos($email, '@') === false) {
                $errors['email'] = 'email должен иметь символ @';
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];

            if (strlen($password) < 5) {
                $errors['psw'] = 'Пароль должен содержать минимум 5 символов';
            }

            if ($password !== ($this->data['psw-repeat'])) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'пароль должен быть заполнен';
        }
        return $errors;
    }
}