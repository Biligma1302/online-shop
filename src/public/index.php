<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;

$autoload = function (string $classname) {
  $path = "./../" . str_replace("\\", "/", $classname) . ".php";

 if (file_exists($path)) {
  require_once $path;
   return true;
   }
    return false;
 };

 spl_autoload_register($autoload);

 $app = new Core\App();

 $app->addRoute('/registration', 'GET', UserController::class,'getRegistrate');
 $app->addRoute('/registration', 'POST', UserController::class,'reegistrate');
 $app->addRoute('/login', 'GET', UserController::class,'getLogin');
 $app->addRoute('/login', 'POST', UserController::class,'login');
 $app->addRoute('/profile', 'GET', UserController::class,'displayProfile');
 $app->addRoute('/profile', 'POST', UserController::class,'getDisplayProfile');
 $app->addRoute('/edit-profile', 'GET', UserController::class,'getEditProfile');
 $app->addRoute('/edit-profile', 'POST', UserController::class,'editProfile');
 $app->addRoute('/catalog', 'GET', ProductController::class,'displayCatalog');
 $app->addRoute('/add-product', 'GET', ProductController::class,'getAddProduct');
 $app->addRoute('/add-product', 'POST', ProductController::class,'addProduct');
 $app->addRoute('/cart', 'GET', CartController::class, 'displayCart');
 $app->addRoute('/create-order', 'GET',  OrderController::class,'getCheckoutForm');
 $app->addRoute('/create-order', 'POST',  OrderController::class,'handleCheckout');
 $app->addRoute('/user-orders', 'GET',  OrderController::class,'getAllOrders');
 $app->addRoute('/order-success', 'GET',  OrderController::class,'displaySuccessOrder');

 $app->run();



