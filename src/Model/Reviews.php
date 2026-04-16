<?php

namespace Model;

class Reviews extends Model
{
    private $rating;
    private $comment;
    private $user_id;
    private $product_id;
    private $created_at;

    protected function getTableName(): string
    {
        return 'reviews';
    }


    public function create( int $user_id, int $product_id, string $comment, int $rating) {
    $stmt = $this->pdo->prepare(
        "INSERT INTO {$this->getTableName()} (user_id, product_id, comment, rating) 
         VALUES (:user_id, :product_id, :comment, :rating)");
     return $stmt->execute([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'comment' => $comment,
            'rating' => $rating
        ]);
    }
    public function getReviewsByProductId(int $product_id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM {$this->getTableName()} WHERE product_id = :product_id"
        );
        $stmt->execute(['product_id' => $product_id]);
       $data= $stmt->fetchAll();
        $reviews = [];
        foreach ($data as $reviewData) {
            $obj = new self();

            $obj->user_id = $reviewData['user_id'];
            $obj->product_id = $reviewData['product_id'];
            $obj->comment = $reviewData['comment'];
            $obj->rating= $reviewData['rating'];
            $obj->created_at = $reviewData['created_at'];
            $reviews[] = $obj;
        }
        return $reviews;
       }
       

    public function getRating()
    {
        return $this->rating;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }


}







