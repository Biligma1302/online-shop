<?php

namespace Model;

class OrderProduct extends Model
{
 public function create (int $order_id, int $product_id, int $amount) {
    $stmt = $this->pdo->prepare(
         "INSERT INTO order_products (order_id, product_id, amount) VALUES (:orderId, :productId, :amount)"
     );
    $stmt->execute (['orderId' => $order_id, 'productId' => $product_id, 'amount' => $amount]);

 }

 public function getAllByOrderId(int $order_id)
 {
     $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :order_id");
     $stmt->execute(['order_id' => $order_id]);
     $orderProducts = $stmt->fetchAll();
     return $orderProducts;

 }
}