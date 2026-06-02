<?php

declare(strict_types=1);

namespace Model;

use DTO\ProductDTO;
use DTO\UserProductDTO;

class UserProduct extends Model
{
    private int $id;
    private int $productId;
    private int $userId;
    private int $amount;

    protected static function getTableName(): string
    {
        return 'user_products';
    }

    public static function getAllByUserIdWithProducts(int $user_id): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT 
                up.id AS up_id, 
                up.user_id, 
                up.product_id, 
                up.amount, 
                p.name, 
                p.description, 
                p.price, 
                p.image_url 
    FROM {$tableName} up 
    INNER JOIN products p ON up.product_id = p.id WHERE up.user_id = :user_id"
        );
        $stmt->execute(['user_id' => $user_id]);

        $userProducts = $stmt->fetchAll();
        $result = [];
        foreach ($userProducts as $userProduct) {
            $userProductDTO = new UserProductDTO(
                (int)$userProduct['up_id'],
                (int)$userProduct['user_id'],
                (int)$userProduct['product_id'],
                (int)$userProduct['amount']
            );
            $productDTO = new ProductDTO(
                $userProduct['name'],
                $userProduct['description'],
                (float)$userProduct['price'],
                $userProduct['image_url']
            );
            $userProductDTO->setProduct($productDTO);

            $result[] = $userProductDTO;
        }
        return $result;
    }

    public static function deleteByUserId(int $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM {$tableName} WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $userId]);
    }

    public static function getUserProduct(int $productId, int $userId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT * FROM {$tableName} WHERE product_id = :product_id AND user_id = :user_id"
        );
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->amount = $data['amount'];

        return $obj;
    }

    public static function insertUserProduct(int $userId, int $productId, int $amount): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)"
        );
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public static function updateUserProduct(int $amount, int $userId, int $productId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "UPDATE {$tableName} SET amount = :amount WHERE user_id = :user_id and product_id = :product_id"
        );
        $stmt->execute(['amount' => $amount, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public static function deleteUserProducts(int $userId, int $productId): bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "DELETE FROM {$tableName} WHERE user_id = :user_id and product_id = :product_id"
        );
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public static function getAmountCartItems(int $userId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll();
        $result = [];
        foreach ($data as $product) {
            $obj = new self();
            $obj->amount = $product['amount'];
            $result[$product['product_id']] = $obj;
        }
        return $result;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}