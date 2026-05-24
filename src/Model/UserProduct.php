<?php

declare(strict_types=1);

namespace Model;

use DTO\UserProductDTO;

class UserProduct extends Model
{
    private int $id;
    private int $product_id;
    private int $user_id;
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
        $user_products = [];
        foreach ($userProducts as $userProduct) {
            $user_products[] = new UserProductDTO(

                $userProduct ['up_id'],
                $userProduct ['user_id'],
                $userProduct ['product_id'],
                $userProduct ['amount'],
                $userProduct ['name'],
                $userProduct ['description'],
                (float)$userProduct['price'],
                $userProduct['image_url']
            );
        }
        return $user_products;
    }

    public static function deleteByUserId(int $user_id): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("DELETE FROM  {$tableName} WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
    }

    public static function getUserProduct(int $product_id, int $user_id): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT * FROM {$tableName} WHERE product_id = :product_id AND user_id = :user_id"
        );
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $data = $stmt->fetch();
        if ($data === false) {
            return null;
        }
        $obj = new self;
        $obj->id = $data['id'];
        $obj->user_id = $data['user_id'];
        $obj->product_id = $data['product_id'];
        $obj->amount = $data['amount'];

        return $obj;
    }

    public static function insertUserProduct(int $user_id, int $product_id, int $amount): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)"
        );
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public static function updateUserProduct(int $amount, int $user_id, int $product_id): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "UPDATE {$tableName} SET amount = :amount WHERE user_id = :user_id and product_id = :product_id"
        );
        $stmt->execute(['amount' => $amount, 'user_id' => $user_id, 'product_id' => $product_id]);
    }

    public static function deleteUserProducts(int $user_id, int $product_id): bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "DELETE FROM {$tableName} WHERE user_id = :user_id and product_id = :product_id"
        );
        return $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    }

    public static function getAmountCartItems(int $user_id): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        $user_products = [];
        foreach ($data as $product) {
            $obj = new self();
            $obj->amount = $product['amount'];
            $user_products[$product['product_id']] = $obj;
        }
        return $user_products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
