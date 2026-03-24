<?php

namespace Controllers;
use Model\Cart;
class cartController
{
    private Cart $cartModel;
    public function __construct()
    {
        $this->cartModel = new Cart();

    }

    public function displayCart() {
          if (session_status() !== PHP_SESSION_ACTIVE) {
              session_start();
          }

          if (!isset($_SESSION['user_id'])) {
              header("Location: /login");
              exit();
  }
          $user_id = $_SESSION['user_id'];


          $userProducts = $this->cartModel->getUserCart($user_id);

          $fullUserProducts = $this->cartModel-> getFull($userProducts);

          require_once '../Views/cart_form.php';

      }
}


