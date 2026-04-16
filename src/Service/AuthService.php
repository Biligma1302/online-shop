<?php

namespace Service;

use Model\User;

class AuthService
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
            $user_id = $_SESSION['user_id'];
            $user = $this->userModel->getByID($user_id);
            return $user;
        } else {
            return null;
        }
    }

    public function auth(string $username, string $password):bool
    {
        $this->startSession();

        $user = $this->userModel->getByUsername($username);

        if ($user === false) {
            return false;
        } else {
            $passwordDb = $user->getPassword();

            if (password_verify($password, $passwordDb)) {

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
    public function logout() {
        $this->startSession();
        session_destroy();
    }

    private function startSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

}