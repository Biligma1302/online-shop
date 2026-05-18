<?php

declare(strict_types=1);

namespace Controllers;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

abstract class Controller
{
    protected AuthInterface $authService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }
}