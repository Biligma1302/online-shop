<?php
namespace Controllers;
use Model\Product;
class productController
{
    private Product $productModel;
    public function __construct()
    {
        $this->productModel = new Product();

    }
    public function displayCatalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }


        $products = $this->productModel->getProducts();

        require_once '../Views/catalog_page.php';
    }

    //добавление продукта
    public function getAddProduct(){
        require_once '../Views/add_product_form.php';
    }
    public function addProduct() {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $errors = $this->addProductValidate($_POST);

        if (empty($errors)) {

            $user_id = $_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $amount = (int)$_POST['amount'];


            $data = $this->productModel->getUserProduct($product_id, $user_id);

            if ($data === false) {
               $this->productModel->insertUserProduct($user_id, $product_id, $amount);
            } else {
                $amount = $data['amount'] + $amount;
               $this->productModel->updateUserProduct($amount, $user_id, $product_id);

            }
        }
        header("Location: /catalog");
        exit();
    }

    function addProductValidate(array $data): array
    {
        $errors = [];
        if (isset($data['product_id'])) {
            $product_id = (int)$data['product_id'];


           $data = $this->productModel->getById($product_id);

            if ($data === false) {
                $errors['product_id'] = 'Продукт не найден';
            }
        } else {
            $errors['product_id'] = 'id продукта должен быть обязательно указан';
        }
        if (isset($data['amount'])) {
            $amount = (int)$data['amount'];

        }
        return $errors;
    }
}