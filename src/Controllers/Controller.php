<?php

namespace Controllers;

use Service\AuthService;

abstract class Controller
  {
   protected  AuthService $authService;

   public function __construct()
   {
       $this->authService = new AuthService();
   }
 }