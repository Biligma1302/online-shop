<?php

namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $order_id;
    private int $product_id;
    private int $amount;

    protected function getTableName(): string
    {
        return 'order_products';
    }

 public function create (int $order_id, int $product_id, int $amount) {
    $stmt = $this->pdo->prepare(
         "INSERT INTO {$this->getTableName()} (order_id, product_id, amount) VALUES (:orderId, :productId, :amount)"
     );
    $stmt->execute (['orderId' => $order_id, 'productId' => $product_id, 'amount' => $amount]);

 }

 public function getAllByOrderId(int $order_id)
 {
     $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE order_id = :order_id");
     $stmt->execute(['order_id' => $order_id]);
     $orderProducts = $stmt->fetchAll();
     $orders = [];
     foreach ($orderProducts as $orderProduct) {
         $obj = new self();
         $obj->id = $orderProduct['id'];
         $obj->order_id = $orderProduct['order_id'];
         $obj->product_id = $orderProduct['product_id'];
         $obj->amount = $orderProduct['amount'];
         $orders[] = $obj;
     }
     return $orders;
 }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}