<?php

declare(strict_types=1);

namespace Controllers;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;

use Model\Product;
use Request\ProductIdRequest;

use Service\CartService;


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
            $totalSum = $this->cartService->getSum();
            require_once '../Views/cart_form.php';
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function addProduct(ProductIdRequest $request)
    {
        $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';

        if (!$this->authService->check()) {
            if ($isAjax) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit();
            }
            header("Location: /login");
            exit();
        }

        $errors = $request->validateProductId();

        if (empty($errors)) {
            $product_id = $request->getProductId();
            $product = Product::getById($product_id);

            if ($product === null) {
                $errors['product_id'] = 'Продукт не найден';
            }
        }

        if (!empty($errors)) {
            if ($isAjax) {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors]);
                exit();
            }

            $_SESSION['errors'] = $errors;
            header("Location: /cart");
            exit();
        }
        $amount = 1;
        $dto = new AddProductDTO($request->getProductId(), $amount);
        $this->cartService->addProduct($dto);

        if ($isAjax) {
            $newAmount = $this->cartService->getProductAmount($request->getProductId());
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'newAmount' => (int)$newAmount
            ]);
            exit();
        }
        header("Location: /cart");
        exit();
    }


    public function decreaseProduct(ProductIdRequest $request)
    {
        $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';

        if (!$this->authService->check()) {
            if ($isAjax) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit();
            }
            header("Location: /login");
            exit();
        }

        $errors = $request->validateProductId();

        if (empty($errors)) {
            $product_id = $request->getProductId();
            $product = Product::getById($product_id);

            if ($product === null) {
                $errors['product_id'] = 'Продукт не найден';
            }
        }

        if (!empty($errors)) {
            if ($isAjax) {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'errors' => $errors]);
                exit();
            }

            $_SESSION['errors'] = $errors;
            header("Location: /cart");
            exit();
        }

        $dto = new DecreaseProductDTO($request->getProductId());
        $this->cartService->decreaseProduct($dto);

        if ($isAjax) {
            $newAmount = $this->cartService->getProductAmount($request->getProductId());
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'newAmount' => (int)$newAmount
            ]);
            exit();
        }
        header("Location: /cart");
        exit();
    }
}