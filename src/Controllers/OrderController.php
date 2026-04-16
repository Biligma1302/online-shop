<?php

namespace Controllers;

use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Model\Product;
use Service\OrderService;


class OrderController extends Controller
 {
    private Order $orderModel;

    private OrderProduct $orderProductModel;
    private Product $productModel;
    private OrderService $orderService;


    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
        $this->orderService = new OrderService();

    }

    public function getCheckoutForm()
    {
        require_once './../Views/order_form.php';
    }

    public function handleCheckout()
    {
        if (!$this->authService->check())  {
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


           $this->orderService->processCheckout($contactName, $contactPhone, $comment, $address, $user_id);

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
        if (!$this->authService->check())
        {
            header("Location:/Login");
            exit();
        }
        $user = $this->authService->getCurrentUser(); ;

        $newUserOrders = $this->orderService->getUserOrdersHistory($user->getId());

        require_once './../Views/My_orders_form.php';
    }
 }




