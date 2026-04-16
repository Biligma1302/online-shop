<?php

namespace Controllers;

use Model\Product;
use Model\UserProduct;
use Model\Reviews;
use Service\CartService;

class ProductController extends Controller
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private Reviews $reviewsModel;
    private CartService $cartService;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel= new UserProduct();
        $this->reviewsModel = new Reviews();
        $this->cartService = new CartService();

    }

    public function displayCatalog()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $products = $this->productModel->getProducts();

        $user = $this->authService->getCurrentUser();;
        $user_products = $this->userProductModel->getAmountCartItems($user->getId());

        require_once '../Views/catalog_page.php';
    }


    public function getAddProduct()
    {
        require_once '../Views/add_product_form.php';
    }

    public function addProduct()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $errors = $this->addProductValidate($_POST);

        if (empty($errors)) {

            $user = $this->authService->getCurrentUser();;
            $product_id = $_POST['product_id'];

            $amount = 1;

            $this->cartService->addProduct($product_id,$user->getId(), $amount);
        }
        header("Location: /catalog");
        exit();
    }

    function addProductValidate(array $data): array
    {
        $errors = [];
        if (isset($data['product_id'])) {
            $product_id = (int)$data['product_id'];


            $product = $this->productModel->getById($product_id);

            if ($product === null) {
                $errors['product_id'] = 'Продукт не найден';
            }
        } else {
            $errors['product_id'] = 'id продукта должен быть обязательно указан';
        }

        return $errors;
    }

    public function decreaseProduct()
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $user = $this->authService->getCurrentUser();;
        $product_id = $_POST['product_id'];

      $this->cartService->decreaseProduct($product_id,$user->getId());

        header("Location: /catalog");
        exit();
    }
    public function getReviewsPage()
    {
        $product_id = $_GET['product_id'];
        if ($product_id) {
            $user = $this->authService->getCurrentUser();
            $product = $this->productModel->getById($product_id);
            if ($product) {
                $reviewsList = $this->reviewsModel->getReviewsByProductId($product_id);
                require_once '../Views/reviews_page.php';
            } else {
                header('Location: /catalog');
                exit;
            }
        }
    }
    public function PostReviews()
    {
        $user = $this->authService->getCurrentUser();

        if (isset($_POST['product_id'], $_POST['rating'], $_POST['comment'])) {

            $productId = $_POST['product_id'];
            $rating = $_POST['rating'];
            $comment = $_POST['comment'];

            $this->reviewsModel->create($user->getId(), $productId, $comment, $rating);

            header("Location: /reviews?product_id=$productId");
            exit;
        }
    }
}