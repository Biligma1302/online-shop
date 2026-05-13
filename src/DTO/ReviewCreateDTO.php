<?php

namespace DTO;

use Model\User;

class ReviewCreateDTO
{
    public function __construct(
        private User $user,
        private int $productId,
        private string $comment,
        private int $rating
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

}