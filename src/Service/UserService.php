<?php

namespace Service;

use DTO\RegisterUserDTO;
use DTO\UpdateProfileDTO;
use Model\User;
use Service\Auth\AuthSessionService;



class UserService
{
    private AuthSessionService $authSessionService;

    public function __construct()
    {
        $this->authSessionService = new AuthSessionService();
    }

    public function registerUser(RegisterUserDTO $dto)
    {
        $result = User::getByEmail($dto->getEmail());

        if ($result) {
            echo "Email уже занят";
        } else {

            $hashedPassword = password_hash($dto->getPassword(), PASSWORD_DEFAULT);

            User::insertInto($dto->getName(), $dto->getEmail(), $hashedPassword);
        }
    }
    public function updateProfile(UpdateProfileDTO $dto)
    {
        $this->authSessionService->check();
        $user = User::getbyId($dto->getUser()->getId());

          if ($user->getName() !== $dto->getName()) {
           User::updateNameById($dto->getName(), $dto->getUser()->getId());

              $_SESSION['user_name'] = $dto->getName();
          }
            if ($user->getEmail() !== $dto->getEmail()) {
           User::updateEmailById($dto->getEmail(), $dto->getUser()->getId());
            }
    }
}
