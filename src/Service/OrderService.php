<?php

namespace Service;

use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Model\Product;

class OrderService
{
    private Order $orderModel;
    private UserProduct $userProductModel;

    private OrderProduct $orderProductModel;
    private Product $productModel;


    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();

    }

    public function processCheckout($contactName, $contactPhone, $comment, $address, $user_id)
    {

        $orderId = $this->orderModel->create($contactName, $contactPhone, $comment, $address, $user_id);

        $userProducts = $this->userProductModel->getAllUserProductsByUserId($user_id);

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();

            $this->orderProductModel->create($orderId, $productId, $amount);
        }

        $this->userProductModel->deleteByUserId($user_id);
    }

    public function getUserOrdersHistory(int $user_id)
    {

        $userOrders = $this->orderModel->getAllByUserId($user_id);
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

