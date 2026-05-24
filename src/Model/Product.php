<?php

declare(strict_types=1);

namespace Model;

class Product extends Model
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url;

    protected static function getTableName(): string
    {
        return 'products';
    }

    public static function getProducts(): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->query("SELECT * FROM {$tableName}");

        $products = $stmt->fetchAll();
        $result = [];

        foreach ($products as $product) {
            $obj = new self();

            $obj->id = $product['id'];
            $obj->name = $product['name'];
            $obj->description = $product['description'];
            $obj->price = (int) $product['price'];
            $obj->image_url = $product['image_url'];

            $result[] = $obj;
        }
        return $result;
    }

    public static function getById(int $product_id): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM {$tableName} WHERE id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch();

        if ($product === false) {
            return null;
        }
        $obj = new self();
        $obj->id = $product['id'];
        $obj->name = $product['name'];
        $obj->description = $product['description'];
        $obj->price = (int)$product['price'];
        $obj->image_url = $product['image_url'];

        return $obj;
    }

    public static function getFull(array $userProducts): array
    {
        $products = [];

        foreach ($userProducts as $userProduct) {
            $product = static::getById($userProduct->getProductId());

            if ($product === null) {
                continue;
            }
            $products[] = [
                'amount' => $userProduct->getAmount(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'image' => $product->getImageUrl(),
                'productId' => $product->getId(),
            ];
        }
        return $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }
}