<?php

declare(strict_types=1);

namespace Service;

use DTO\AddProductDTO;
use DTO\DecreaseProductDTO;

use Model\UserProduct;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService
{
    private AuthInterface $authService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();
        if ($user === null) {
            return [];
        }
        $userProducts = UserProduct::getAllByUserIdWithProducts($user->getId());

        $products = [];

        foreach ($userProducts as $userProduct) {
            $products[] = [
                'amount' => $userProduct->getAmount(),
                'name' => $userProduct->getName(),
                'price' => $userProduct->getPrice(),
                'image' => $userProduct->getImageUrl(),
                'productId' => $userProduct->getProductId(),
            ];
        }
        return $products;
    }

    public function addProduct(AddProductDTO $dto): void
    {
        $user = $this->authService->getCurrentUser();
        $data = UserProduct::getUserProduct($dto->getProductId(), $user->getId());

        if ($data === null) {
            UserProduct::insertUserProduct
            (
                $user->getId(),
                $dto->getProductId(),
                $dto->getAmount()
            );
        } else {
            $newAmount = $data->getAmount() + $dto->getAmount();
            UserProduct::updateUserProduct
            (
                $newAmount,
                $user->getId(),
                $dto->getProductId()
            );
        }
    }

    public function decreaseProduct(DecreaseProductDTO $dto): void
    {
        $user = $this->authService->getCurrentUser();
        $data = UserProduct::getUserProduct($dto->getProductId(), $user->getId());

        if ($data) {
            $newAmount = $data->getAmount() - 1;
            if ($newAmount > 0) {
                UserProduct::updateUserProduct($newAmount, $user->getId(), $data->getProductId());
            } else {
                UserProduct::deleteUserProducts($user->getId(), $dto->getProductId());
            }
        }
    }

    public function getProductAmount(int $productId): int
     {
         $user = $this->authService->getCurrentUser();
         if ($user === null) { return 0; }
         $data = UserProduct::getUserProduct($productId, $user->getId());
         return $data ? $data->getAmount() : 0;
     }

    public function getSum(): float
    {
        $total = 0;
        foreach ($this->getUserProducts() as $userProduct) {
            $total += $userProduct['price'] * $userProduct['amount'];
        }
        return $total;
    }
}
