<?php

namespace Controllers;

use Model\Order;
use Model\Cart;
use Model\OrderProduct;
use Model\Product;



class OrderController
{
    private Order $orderModel;
    private Cart $cartModel;
    private OrderProduct $orderProductModel;
    private Product $productModel;



    public function __construct()
    {
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();

    }

    public function getCheckoutForm()
    {
        require_once './../Views/order_form.php';
    }

    public function handleCheckout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location:/Login");
            exit();
        }

        $errors = $this->validate($_POST);
        if (empty($errors)) {

            $contactName = $_POST['contact_name'];
            $contactPhone = $_POST['contact_phone'];
            $comment = $_POST['comment'];
            $address = $_POST['address'];
            $user_id = $_SESSION['user_id'];


            $orderId = $this->orderModel->create($contactName, $contactPhone, $comment, $address, $user_id);

            $userProducts = $this->cartModel->getUserCart($user_id);

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct['product_id'];
                $amount = $userProduct['amount'];

                $this->orderProductModel->create($orderId, $productId, $amount);
            }

            $this->cartModel->deleteByUserId($user_id);

            header("Location: /order-success");
            exit();

        } else {
            require_once './../Views/order_form.php';
        }
    }


    private function validate(array $data): array
    {
        $errors = [];

        if (isset($data ['contact_name'])) {
            $name = $data['contact_name'];

            if (strlen($name) < 5) {
                $errors['contact_name'] = 'Имя должно содержать минимум 5 символов';
            }
        } else {
            $errors['contact_name'] = 'Имя должно быть заполнено';
        }

        if (isset($data['contact_phone'])) {
            $contactPhone = $data['contact_phone'];
            if (strlen($contactPhone) < 11) {
                $errors['contact_phone'] = 'Неккоректный номер телефона (минимум 11 символов)';
            }
        } else {
            $errors['contact_phone'] = 'Номер должен быть заполнен';
        }

        if (isset($data['address'])) {
            $address = $data['address'];
            if (strlen($address) < 11) {
                $errors['address'] = 'Слишком короткий адрес';
            }
        } else {
            $errors['address'] = 'Адрес должен быть заполнен';
        }


        return $errors;
    }

    public function displaySuccessOrder()
    {
        require_once './../Views/success.php';
    }

    public function getAllOrders()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location:/Login");
            exit();
        }
        $user_id = $_SESSION['user_id'];

        $userOrders = $this->orderModel->getAllByUserId($user_id);

        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {

            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder['id']);

            $newOrderProducts = [];
            $sum = 0;

            foreach ($orderProducts as $orderProduct) {

                $product = $this->productModel->getById($orderProduct['product_id']);
                $orderProduct['name'] = $product['name'];
                $orderProduct['price'] = $product['price'];
                $orderProduct['totalSum'] = $orderProduct['amount'] * $orderProduct['price'];

                $newOrderProducts[] = $orderProduct;

                $sum = $sum + $orderProduct['totalSum'];
            }

            $userOrder['total'] = $sum;

            $userOrder['products'] = $newOrderProducts;

            $newUserOrders[] = $userOrder;
        }
        require_once './../Views/My_orders_form.php';
    }
}





