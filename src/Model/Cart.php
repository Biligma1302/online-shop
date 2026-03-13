<?php

class Cart
{
    private PDO $PDO;
    public function __construct(){
        $this->PDO = new PDO('pgsql:host=postgres_db; port=5432;dbname=dugarovadb', 'dugarova', 'Dugarova1302');
    }
    public function getUserCart(int $user_id)
    {
        $stmt=$this->PDO->query("SELECT * FROM user_products WHERE user_id = {$user_id}");
        $userProducts = $stmt->fetchAll();
        return $userProducts;
    }

    public function getFull($userProducts) {
        $products =[];

        foreach ($userProducts as $userProduct) {

           $product_id = $userProduct['product_id'];
           $stmt = $this->PDO->query("SELECT * FROM products WHERE id = $product_id");
           $product = $stmt->fetch();
           $products[] = $product;
        }
        return $products;

    }

}