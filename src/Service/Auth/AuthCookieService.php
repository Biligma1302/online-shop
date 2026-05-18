<?php

namespace Service\Auth;

use DTO\AuthDTO;
use Model\User;

class AuthCookieService implements AuthInterface
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if ($this->check()) {
            $user_id = $_COOKIE['user_id'];
            $user = $this->userModel->getById($user_id);
            return $user;
        } else {
            return null;
        }
    }

    public function auth(AuthDTO $dto): bool
    {
        $user = $this->userModel->getByUsername($dto->getUsername());

        if ($user === null) {
            return false;
        } else {
            $passwordDb = $user->getPassword();

            if (password_verify($dto->getPassword(), $passwordDb)) {
                setcookie('logged_in', 'true');
                setcookie('user_id', $user->getId());
                setcookie('user_name', $user->getName());
                setcookie('user_email', $user->getEmail());

                return true;
            } else {
                return false;
            }
        }
    }

    public function logout(): void
    {
        setcookie('logged_in', '', time() - 3600, '/');
        setcookie('user_id', '', time() - 3600, '/');
        setcookie('user_name', '', time() - 3600, '/');
        setcookie('user_email', '', time() - 3600, '/');

        unset($_COOKIE['logged_in']);
        unset($_COOKIE['user_id']);
        unset($_COOKIE['user_name']);
        unset($_COOKIE['user_email']);
    }
}
