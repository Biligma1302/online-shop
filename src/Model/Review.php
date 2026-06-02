<?php

declare(strict_types=1);

namespace Model;

class Review extends Model
{
    private int $rating;
    private string $comment;
    private int $userId;
    private int $productId;
    private ?string $createdAt;

    protected static function getTableName(): string
    {
        return 'reviews';
    }

    public static function create(int $userId, int $productId, string $comment, int $rating): bool
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (user_id, product_id, comment, rating) 
         VALUES (:user_id, :product_id, :comment, :rating)"
        );
        return $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'comment' => $comment,
            'rating' => $rating
        ]);
    }

    public static function getReviewsByProductId(int $productId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT * FROM {$tableName} WHERE product_id = :product_id"
        );
        $stmt->execute(['product_id' => $productId]);
        $data = $stmt->fetchAll();
        $reviews = [];
        foreach ($data as $reviewData) {
            $obj = new self();

            $obj->userId = $reviewData['user_id'];
            $obj->productId = $reviewData['product_id'];
            $obj->comment = $reviewData['comment'];
            $obj->rating = $reviewData['rating'];
            $obj->createdAt = $reviewData['created_at'];
            $reviews[] = $obj;
        }
        return $reviews;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}