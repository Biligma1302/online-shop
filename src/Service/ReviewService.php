<?php

namespace Service;

use DTO\ReviewCreateDTO;
use Model\Reviews;

class ReviewService
{

public function createReviews(reviewCreateDTO $dto)
{
    Reviews::create
    (
        $dto->getUser()->getId(),
        $dto->getProductId(),
        $dto->getComment(),
        $dto->getRating()
    );
}
}