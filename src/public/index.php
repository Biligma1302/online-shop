<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\Autoloader;
use Controllers\ReviewController;
use Request\EditProfileRequest;
use Request\ProductIdRequest;
use Request\OrderCreateRequest;
use Request\ReviewCreateRequest;

require_once "./../Core/Autoloader.php";

$path = dirname(__DIR__);
\Core\Autoloader::register($path);




 $app = new Core\App();

 $app->get('/registration', UserController::class,'getRegistrateForm');
 $app->post('/registration', UserController::class,'registrate', \Request\RegistrationRequest::class);
 $app->get('/login', UserController::class,'getLogin');
 $app->post('/login',UserController::class,'login', \Request\LoginRequest::class);
 $app->get('/profile', UserController::class,'displayProfile');
 $app->post('/profile', UserController::class,'getDisplayProfile');
 $app->get('/edit-profile', UserController::class,'getEditProfile');
 $app->post('/edit-profile',  UserController::class,'editProfile', EditProfileRequest::class);
 $app->get('/catalog',  ProductController::class,'getCatalog');
 $app->post('/add-product',  ProductController::class,'addProduct', ProductIdRequest::class);
 $app->get('/cart',  CartController::class, 'getCart');
 $app->get('/create-order',   OrderController::class,'getCheckoutForm');
 $app->post('/create-order',  OrderController::class,'handleCheckout', OrderCreateRequest::class);
 $app->get('/user-orders',  OrderController::class,'getAllOrders');
 $app->get('/order-success',  OrderController::class,'displaySuccessOrder');
 $app->post('/decrease-product', ProductController::class, 'decreaseProduct', ProductIdRequest::class);
 $app->post('/addProduct', CartController::class, 'addProductToCart', \Request\ProductIdRequest::class);
 $app->post('/decreaseProduct', CartController::class, 'decreaseProductFromCart', ProductIdRequest::class);
 $app->get('/reviews',  ReviewController::class,'getReviewsPage');
 $app->post('/reviews-post',  ReviewController::class,'postReviews', ReviewCreateRequest::class);
 $app->get('/logout', UserController::class,'logout');
 $app->run();



