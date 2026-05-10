<?php

namespace Controllers;

use DTO\DecreaseProductDTO;
use Model\Product;
use Model\UserProduct;
use Request\ProductIdRequest;
use Service\CartService;
use DTO\AddProductDTO;

class ProductController extends Controller
{
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->cartService = new CartService();

    }

    public function getCatalog()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        $user = $this->authService->getCurrentUser();

        $products = Product::getProducts();

        $user_products = UserProduct::getAmountCartItems($user->getId());
        $totalSum = $this->cartService->getSum();

        require_once '../Views/catalog_page.php';
    }



    public function addProduct(ProductIdRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $errors = $request->addProductValidate();

        if (empty($errors)) {
            $product_id = $request->getProductId();
            $product = Product::getById($product_id);

            if ($product === null) {
                $errors['product_id'] = 'Продукт не найден';
            }
        }

        if (empty($errors)) {

            $amount = 1;

            $dto = new AddProductDTO($request->getProductId(), $amount);

            $this->cartService->addProduct($dto);
        }
        header("Location: /catalog");
        exit();
    }


    public function decreaseProduct(ProductIdRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $dto = new DecreaseProductDTO($request->getProductId());

      $this->cartService->decreaseProduct($dto);

        header("Location: /catalog");
        exit();
    }
}