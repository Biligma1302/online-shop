<?php

declare(strict_types=1);

namespace Model;

use DTO\OrderHistoryDTO;
use DTO\OrderProductDTO;

class Order extends Model
{
    private int $id;
    private int $userId;
    private string $contactName;
    private string $contactPhone;
    private string $comment;
    private string $address;

    protected static function getTableName(): string
    {
        return 'orders';
    }

    public static function create(
        string $contactName,
        string $contactPhone,
        string $comment,
        string $address,
        int $userId
    ): int {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (contact_name, contact_phone, comment, address, user_id) 
                   VALUES (:contact_name, :contact_phone, :comment, :address, :user_id) RETURNING id"
        );

        $stmt->execute([
            'contact_name' => $contactName,
            'contact_phone' => $contactPhone,
            'comment' => $comment,
            'address' => $address,
            'user_id' => $userId
        ]);
        $data = $stmt->fetch();
        return $data['id'];
    }

    public static function getAllByUserId(int $user_id): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT 
            o.id AS order_id, 
            o.user_id, 
            o.contact_name, 
            o.contact_phone, 
            o.comment, 
            o.address,
            p.id AS product_id, 
            p.name AS product_name, 
            p.price AS product_price, 
            p.image_url,
            op.amount
    FROM {$tableName} o
                   INNER JOIN order_products op ON o.id=op.order_id 
                   INNER JOIN products p ON op.product_id=p.id
                   WHERE o.user_id = :user_id"
        );
        $stmt->execute(['user_id' => $user_id]);
        $userOrders = $stmt->fetchAll();

        $orders = [];

        foreach ($userOrders as $userOrder) {
            $orderId = (int)$userOrder['order_id'];
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = new OrderHistoryDTO(
                    $orderId,
                    $userOrder['contact_name'],
                    $userOrder['contact_phone'],
                    $userOrder['address'],
                    $userOrder['comment']
                );
            }
            $orderProductDTO = new OrderProductDTO(
                $userOrder['product_name'],
                (float) $userOrder['product_price'],
                (int)$userOrder['amount'],
                $userOrder['image_url']
            );
            $orders[$orderId]->addProduct($orderProductDTO);
        }
        return $orders;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getId(): int
    {
        return $this->id;
    }
}