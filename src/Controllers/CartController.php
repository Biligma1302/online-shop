<?php

namespace Controllers;

use Model\UserProduct;
use Model\Product;
use Service\CartService;

class CartController extends Controller
 {
    private UserProduct $userProductModel;
    private Product $productModel;

    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->cartService = new CartService();
    }

    public function displayCart(): void
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());
            $fullUserProducts = $this->productModel->getFull($userProducts);
            require_once '../Views/cart_form.php';
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function addProductToCart()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        $user = $this->authService->getCurrentUser();
        $product_id = $_POST['product_id'];

        $amount = 1;

       $this->cartService->addProduct($product_id, $user->getId(), $_POST['amount']);
        header("Location: /cart");
        exit();
    }
    public function decreaseProductFromCart()
    {
       if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $user = $this->authService->getCurrentUser();

        $product_id = $_POST['product_id'];

        $this->cartService->decreaseProduct($product_id, $user->getId());

        header("Location: /cart");
        exit();
    }
}








