<?php
class Product
{
    private PDO $PDO;
    public function __construct(){
        $this->PDO = new PDO('pgsql:host=postgres_db; port=5432;dbname=dugarovadb', 'dugarova', 'Dugarova1302');
    }
    public function getProducts()
    {
        $stmt=$this->PDO->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getUserProduct(int $product_id, int $user_id)
    {
        $stmt = $this->PDO->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $data = $stmt->fetch();
        return $data;

    }

    public function insertUserProduct(int $user_id, int $product_id, int $amount)
    {
        $stmt = $this->PDO->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function updateUserProduct(int $amount, int $user_id, int $product_id)
    {
        $stmt = $this->PDO->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id and product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $user_id, 'product_id' => $product_id]);
    }

    public function getById(int $product_id): array
    {
        $stmt = $this->PDO->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetch();
        return $data;
    }
}

