<?php

namespace Service;

use DTO\ReviewCreateDTO;
use Model\Reviews;

class ReviewService
{
    private Reviews $reviewsModel;

    public function __construct(){
        $this->reviewsModel = new Reviews();
    }
public function createReviews(reviewCreateDTO $dto)
{
    $this->reviewsModel->create
    (
        $dto->getUser()->getId(),
        $dto->getProductId(),
        $dto->getComment(),
        $dto->getRating()
    );
}
}