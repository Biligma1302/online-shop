<?php

namespace Service;

use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Model\Product;
use DTO\OrderCreateDTO;


class OrderService
{
    private Order $orderModel;
    private UserProduct $userProductModel;

    private OrderProduct $orderProductModel;
    private Product $productModel;
    private AuthService $authService;


    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
        $this->authService = new AuthService();

    }

    public function processCheckout(OrderCreateDTO $data)
    {
        $user = $this->authService->getCurrentUser();
        $orderId = $this->orderModel->create
        (
            $data->getContactName(),
            $data->getContactPhone(),
            $data->getComment(),
            $data->getAddress(),
            $user->getId()
        );

        $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();

            $this->orderProductModel->create($orderId, $productId, $amount);
        }

        $this->userProductModel->deleteByUserId($user->getId());
    }

    public function getUserOrdersHistory():array
    {
        $user = $this->authService->getCurrentUser();

        $userOrders = $this->orderModel->getAllByUserId($user->getId());
        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {
            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());
            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getById($orderProduct->getProductId());

                $totalSum = $orderProduct->getAmount() * $product->getPrice();
                $sum += $totalSum;

                $newOrderProducts[] = [
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'amount' => $orderProduct->getAmount(),
                    'totalSum' => $totalSum
                ];
            }
            $newUserOrders[] = [
                'id' => $userOrder->getId(),
                'contact_name' => $userOrder->getContactName(),
                'contact_phone' => $userOrder->getContactPhone(),
                'address' => $userOrder->getAddress(),
                'total' => $sum,
                'products' => $newOrderProducts
            ];
        }
        return $newUserOrders;
    }
}

