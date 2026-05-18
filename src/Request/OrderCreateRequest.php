<?php

declare(strict_types=1);

namespace Request;

class OrderCreateRequest
{
    public function __construct(private array $data)
    {
    }

    public function getContactName(): string
    {
        return $this->data['contact_name'];
    }

    public function getContactPhone(): string
    {
        return $this->data['contact_phone'];
    }

    public function getComment(): string
    {
        return $this->data['comment'];
    }

    public function getAddress(): string
    {
        return $this->data['address'];
    }

    public function validate(): array
    {
        $errors = [];

        if (isset($this->data ['contact_name'])) {
            $name = $this->data['contact_name'];

            if (strlen($name) < 5) {
                $errors['contact_name'] = 'Имя должно содержать минимум 5 символов';
            }
        } else {
            $errors['contact_name'] = 'Имя должно быть заполнено';
        }

        if (isset($this->data['contact_phone'])) {
            $contactPhone = $this->data['contact_phone'];
            if (strlen($contactPhone) < 11) {
                $errors['contact_phone'] = 'Неккоректный номер телефона (минимум 11 символов)';
            }
        } else {
            $errors['contact_phone'] = 'Номер должен быть заполнен';
        }

        if (isset($this->data['address'])) {
            $address = $this->data['address'];
            if (strlen($address) < 11) {
                $errors['address'] = 'Слишком короткий адрес';
            }
        } else {
            $errors['address'] = 'Адрес должен быть заполнен';
        }
        return $errors;
    }
}

