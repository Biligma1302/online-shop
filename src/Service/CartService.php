<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }

    public function addProduct(int $product_id, int $user_id, int $amount)
    {

        $data = $this->userProductModel->getUserProduct($product_id, $user_id);

        if ($data === null) {
            $this->userProductModel->insertUserProduct($user_id, $product_id, $amount);
        } else {
            $amount = $data->getAmount() + $amount;
            $this->userProductModel->updateUserProduct($amount, $user_id, $product_id);
        }
    }


    public function decreaseProduct(int $product_id, int $user_id)
    {
        $data = $this->userProductModel->getUserProduct($product_id, $user_id);

        if ($data) {
            $newAmount = $data->getAmount() - 1;
            if ($newAmount > 0) {
                $this->userProductModel->updateUserProduct($newAmount, $user_id, $product_id);
            } else {
                $this->userProductModel->deleteUserProducts($user_id, $product_id);
            }
        }
    }
}






