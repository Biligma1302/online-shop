<?php

namespace Controllers;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

abstract class Controller
  {
   protected  AuthInterface $authService;

   public function __construct()
   {
       $this->authService = new AuthSessionService();
   }
 }