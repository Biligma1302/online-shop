<?php

namespace Service;

use DTO\DecreaseProductDTO;
use Model\UserProduct;
use DTO\AddProductDTO;
use Model\Product;

class CartService
{
    private UserProduct $userProductModel;
    private Product $productModel;
    private AuthService $authService;


    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->authService = new AuthService();
    }


    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();
        $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());

        $products = [];

        foreach ($userProducts as $userProduct) {

            $product = $this->productModel->getById($userProduct->getProductId());

            if ($product) {
                $products[] = [
                    'amount' => $userProduct->getAmount(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'image' => $product->getImageUrl(),
                    'productId' => $product->getId(),
                ];
            }
        }
        return $products;
    }



    public function addProduct(AddProductDTO $dto)
    {
        $user = $this->authService->getCurrentUser();
        $data = $this->userProductModel->getUserProduct($dto->getProductId(), $user->getId());

        if ($data === null) {
            $this->userProductModel->insertUserProduct
            (
                $user->getId(),
                $dto->getProductId(),
                $dto->getAmount()
            );

        } else {
            $newAmount = $data->getAmount() + $dto->getAmount();
            $this->userProductModel->updateUserProduct
            (
                $newAmount,
                $user->getId(),
                $dto->getProductId()
            );
        }
    }


    public function decreaseProduct(DecreaseProductDTO $dto)
    {
        $user = $this->authService->getCurrentUser();
        $data = $this->userProductModel->getUserProduct($dto->getProductId(), $user->getId());

        if ($data) {
            $newAmount = $data->getAmount() - 1;
            if ($newAmount > 0) {
                $this->userProductModel->updateUserProduct($newAmount, $user->getId(), $data->getProductId());
            } else {
                $this->userProductModel->deleteUserProducts($user->getId(), $dto->getProductId());
            }
        }
    }
}






