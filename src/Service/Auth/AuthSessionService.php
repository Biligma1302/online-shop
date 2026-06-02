<?php

declare(strict_types=1);

namespace Service\Auth;

use DTO\AuthDTO;

use Model\User;

class AuthSessionService implements AuthInterface
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function check(): bool
    {
        $this->startSession();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        $this->startSession();
        if ($this->check()) {
            $userId = $_SESSION['user_id'];
            $user = $this->userModel->getById($userId);
            return $user;
        } else {
            return null;
        }
    }

    public function auth(AuthDTO $dto): bool
    {
        $this->startSession();

        $user = $this->userModel->getByUsername($dto->getUsername());

        if ($user === null) {
            return false;
        } else {
            $passwordDb = $user->getPassword();

            if (password_verify($dto->getPassword(), $passwordDb)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getName();
                $_SESSION['user_email'] = $user->getEmail();

                return true;
            } else {
                return false;
            }
        }
    }

    public function logout(): void
    {
        $this->startSession();
        session_destroy();
    }

    private function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}