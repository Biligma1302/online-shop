<?php

declare(strict_types=1);

namespace Controllers;

use DTO\OrderCreateDTO;

use Request\OrderCreateRequest;

use Service\OrderService;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
    }

    public function getCheckoutForm():void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        require_once './../Views/order_form.php';
    }

    public function handleCheckout(OrderCreateRequest $request): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        $errors = $request->validate();
        if (empty($errors)) {
            $dto = new OrderCreateDTO(
                $request->getContactName(),
                $request->getContactPhone(),
                $request->getComment(),
                $request->getAddress(),
            );
            $this->orderService->processCheckout($dto);

            header("Location: /order-success");
            exit();
        } else {
            require_once './../Views/order_form.php';
        }
    }

    public function displaySuccessOrder(): void
    {
        require_once './../Views/success.php';
    }

    public function getAllOrders(): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        $newUserOrders = $this->orderService->getUserOrdersHistory();

        require_once './../Views/My_orders_form.php';
    }
}
