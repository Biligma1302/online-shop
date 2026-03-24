<?php
namespace Model;
class Product extends Model
{

    public function getProducts()
    {
        $stmt = $this->pdo->query('SELECT * FROM products');

        $products = $stmt->fetchAll();
        return $products;
    }

    public function getUserProduct(int $product_id, int $user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $data = $stmt->fetch();
        return $data;

    }

    public function insertUserProduct(int $user_id, int $product_id, int $amount)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function updateUserProduct(int $amount, int $user_id, int $product_id)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id and product_id = :product_id");
        $stmt->execute(['amount' => $amount, 'user_id' => $user_id, 'product_id' => $product_id]);
    }

    public function getById(int $product_id): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetch();
        return $data;
    }

}