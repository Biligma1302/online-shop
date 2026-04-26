<?php

namespace Controllers;

use Service\CartService;
use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;
use Request\ProductIdRequest;


class CartController extends Controller
 {
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();

        $this->cartService = new CartService();
    }

    public function getCart(): void
    {
        if ($this->authService->check()) {
            $userProducts = $this->cartService->getUserProducts();
            require_once '../Views/cart_form.php';
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function addProductToCart(ProductIdRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $amount = 1;

        $dto = new AddProductDTO($request->getProductId(), $amount);

       $this->cartService->addProduct($dto);
        header("Location: /cart");
        exit();
    }

    public function decreaseProductFromCart(ProductIdRequest $request)
    {
       if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $dto = new DecreaseProductDTO($request->getProductId());

        $this->cartService->decreaseProduct($dto);

        header("Location: /cart");
        exit();
    }
}








