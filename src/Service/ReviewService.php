<?php

declare(strict_types=1);

namespace Service;

use DTO\ReviewCreateDTO;

use Model\Review;

class ReviewService
{
    public function createReviews(ReviewCreateDTO $dto): void
    {
        Review::create
        (
            $dto->getUser()->getId(),
            $dto->getProductId(),
            $dto->getComment(),
            $dto->getRating()
        );
    }
}