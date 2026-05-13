<?php

namespace DTO;

use Model\User;

class UpdateProfileDTO
{
    public function __construct(
        private User $user,
        private string $name,
        private string $email,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}