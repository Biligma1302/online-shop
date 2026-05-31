<?php

declare(strict_types=1);

namespace Service;

use DTO\OrderCreateDTO;

use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private AuthInterface $authService;
    private CartService $cartService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }

    public function processCheckout(OrderCreateDTO $data): void
    {
        $sum = $this->cartService->getSum();
        if ($sum < 1000) {
            throw new \Exception ('Для оформления заказа сумма корзины должна быть больше 1000');
        }

        $user = $this->authService->getCurrentUser();
        $orderId = Order::create(
            $data->getContactName(),
            $data->getContactPhone(),
            $data->getComment(),
            $data->getAddress(),
            $user->getId()
        );

        $userProducts = UserProduct::getAllByUserIdWithProducts($user->getId());

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $amount = $userProduct->getAmount();

            OrderProduct::create($orderId, $productId, $amount);
        }

        UserProduct::deleteByUserId($user->getId());
    }

    public function getUserOrdersHistory(): array
    {
        $user = $this->authService->getCurrentUser();

        return Order::getAllByUserId($user->getId());
    }
}