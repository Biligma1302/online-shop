<?php

namespace Controllers;

use Service\OrderService;
use DTO\OrderCreateDTO;
use Request\OrderCreateRequest;


class OrderController extends Controller
{
    private OrderService $orderService;


    public function __construct()
    {
        parent::__construct();
        $this->orderService = new OrderService();
    }

    public function getCheckoutForm()
    {
        require_once './../Views/order_form.php';
    }

    public function handleCheckout(OrderCreateRequest $request)
    {
        if (!$this->authService->check()) {
            header("Location:/Login");
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


    public function displaySuccessOrder()
    {
        require_once './../Views/success.php';
    }

    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header("Location:/Login");
            exit();
        }

        $newUserOrders = $this->orderService->getUserOrdersHistory();

        require_once './../Views/My_orders_form.php';
    }
}




