<?php

class cartController
{
      public function displayCart() {
          if (session_status() !== PHP_SESSION_ACTIVE) {
              session_start();
          }

          if (!isset($_SESSION['user_id'])) {
              header("Location: /login");
              exit();
  }
          $user_id = $_SESSION['user_id'];

          require_once '../Model/Cart.php';
          $cartModel = new Cart();
          $userProducts = $cartModel->getUserCart($user_id);

          $fullUserProducts = $cartModel-> getFull($userProducts);

          require_once '../Views/cart_form.php';

      }

}


