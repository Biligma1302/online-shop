<?php

namespace Service;

use DTO\RegisterUserDTO;
use DTO\UpdateProfileDTO;
use Model\User;


class UserService
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function registerUser(RegisterUserDTO $dto)
    {
        $result = $this->userModel->getByEmail($dto->getEmail());

        if ($result) {
            echo "Email уже занят";
        } else {

            $hashedPassword = password_hash($dto->getPassword(), PASSWORD_DEFAULT);

            $this->userModel->insertInto($dto->getName(), $dto->getEmail(), $hashedPassword);
        }
    }
    public function updateProfile(UpdateProfileDTO $dto)
    {
        $user = $this->userModel->getbyId($dto->getUser()->getId());

          if ($user->getName() !== $dto->getName()) {
           $this->userModel-> updateNameById($dto->getName(), $dto->getUser()->getId());
    }
            if ($user->getEmail() !== $dto->getEmail()) {
            $this->userModel-> updateEmailById($dto->getEmail(), $dto->getUser()->getId());
            }
    }
}
