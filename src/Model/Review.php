<?php

declare(strict_types=1);

namespace Model;

class Review extends Model
{
    private int $rating;
    private string $comment;
    private int $user_id;
    private int $product_id;
    private ?string $created_at;

    protected static function getTableName(): string
    {
        return 'reviews';
    }


    public static function create(int $user_id, int $product_id, string $comment, int $rating)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "INSERT INTO {$tableName} (user_id, product_id, comment, rating) 
         VALUES (:user_id, :product_id, :comment, :rating)"
        );
        return $stmt->execute([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'comment' => $comment,
            'rating' => $rating
        ]);
    }

    public static function getReviewsByProductId(int $product_id): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare(
            "SELECT * FROM {$tableName} WHERE product_id = :product_id"
        );
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetchAll();
        $reviews = [];
        foreach ($data as $reviewData) {
            $obj = new self();

            $obj->user_id = $reviewData['user_id'];
            $obj->product_id = $reviewData['product_id'];
            $obj->comment = $reviewData['comment'];
            $obj->rating = $reviewData['rating'];
            $obj->created_at = $reviewData['created_at'];
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
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }


}







