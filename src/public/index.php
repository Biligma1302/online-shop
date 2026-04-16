<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\Autoloader;

require_once "./../Core/Autoloader.php";

$path = dirname(__DIR__);
\Core\Autoloader::register($path);




 $app = new Core\App();

 $app->get('/registration', UserController::class,'getRegistrate');
 $app->post('/registration', UserController::class,'registrate');
 $app->get('/login', UserController::class,'getLogin');
 $app->post('/login',UserController::class,'login');
 $app->get('/profile', UserController::class,'displayProfile');
 $app->post('/profile', UserController::class,'getDisplayProfile');
 $app->get('/edit-profile', UserController::class,'getEditProfile');
 $app->post('/edit-profile',  UserController::class,'editProfile');
 $app->get('/catalog',  ProductController::class,'displayCatalog');
 $app->get('/add-product', ProductController::class,'getAddProduct');
 $app->post('/add-product',  ProductController::class,'addProduct');
 $app->get('/cart',  CartController::class, 'displayCart');
 $app->get('/create-order',   OrderController::class,'getCheckoutForm');
 $app->post('/create-order',  OrderController::class,'handleCheckout');
 $app->get('/user-orders',  OrderController::class,'getAllOrders');
 $app->get('/order-success',  OrderController::class,'displaySuccessOrder');
 $app->post('/decrease-product', ProductController::class, 'decreaseProduct');
$app->post('/addProduct', CartController::class, 'addProductToCart');
$app->post('/decreaseProduct', CartController::class, 'decreaseProductFromCart');
$app->get('/reviews',  ProductController::class,'getReviewsPage');
$app->post('/reviews-post',  ProductController::class,'postReviews');
$app->get('/logout', UserController::class,'logout');
 $app->run();



