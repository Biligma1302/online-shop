<?php

$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
    foreach (parse_ini_file($envFile) as $key => $value)
    {
        putenv("$key=$value");
    }
}

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Controllers\ReviewController;

use Request\UpdateProfileRequest;
use Request\ProductIdRequest;
use Request\OrderCreateRequest;
use Request\ReviewCreateRequest;

require_once "./../Core/Autoloader.php";

$path = dirname(__DIR__);
\Core\Autoloader::register($path);

$app = new Core\App();

$app->get('/registration', UserController::class, 'getRegistrateForm');
$app->post('/registration', UserController::class, 'registrate', \Request\RegistrationRequest::class);
$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login', \Request\LoginRequest::class);
$app->get('/profile', UserController::class, 'showProfile');
$app->get('/edit-profile', UserController::class, 'editProfile');
$app->post('/edit-profile', UserController::class, 'updateProfile', UpdateProfileRequest::class);
$app->get('/catalog', ProductController::class, 'getCatalog');
$app->post('/add-product', ProductController::class, 'addProduct', ProductIdRequest::class);
$app->get('/cart', CartController::class, 'getCart');
$app->get('/create-order', OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout', OrderCreateRequest::class);
$app->get('/user-orders', OrderController::class, 'getAllOrders');
$app->get('/order-success', OrderController::class, 'displaySuccessOrder');
$app->post('/decrease-product', ProductController::class, 'decreaseProduct', ProductIdRequest::class);
$app->post('/addProduct', CartController::class, 'addProduct', \Request\ProductIdRequest::class);
$app->post('/decreaseProduct', CartController::class, 'decreaseProduct', ProductIdRequest::class);
$app->get('/reviews', ReviewController::class, 'getReviews');
$app->post('/reviews-post', ReviewController::class, 'postReviews', ReviewCreateRequest::class);
$app->get('/logout', UserController::class, 'logout');
$app->run();