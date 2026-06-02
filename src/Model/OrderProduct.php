<?php

declare(strict_types=1);

namespace Model;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;

    protected static function getTableName(): string
    {
        return 'order_products';
    }

    public static function create(int $orderId, int $productId, int $amount): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (order_id, product_id, amount) VALUES (:orderId, :productId, :amount)"
        );
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount]);
    }

    public static function getAllByOrderId(int $orderId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        $orderProducts = $stmt->fetchAll();
        $orders = [];
        foreach ($orderProducts as $orderProduct) {
            $obj = new self();
            $obj->id = $orderProduct['id'];
            $obj->orderId = $orderProduct['order_id'];
            $obj->productId = $orderProduct['product_id'];
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
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}