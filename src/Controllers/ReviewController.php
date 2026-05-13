<?php

namespace Controllers;

use DTO\ReviewCreateDTO;
use Model\Product;
use Model\Reviews;
use Request\ReviewCreateRequest;
use Service\ReviewService;

class ReviewController extends Controller
{
    private ReviewService $reviewService;

    public function __construct()
    {
        parent::__construct();
        $this->reviewService = new ReviewService();
    }

    public function getReviews()
    {
        $product_id = $_GET['product_id'];
        if ($product_id) {
            $user = $this->authService->getCurrentUser();
            $product = Product::getById($product_id);
            if ($product) {
                $reviewsList = Reviews::getReviewsByProductId($product_id);
                require_once '../Views/reviews_page.php';
            } else {
                header('Location: /catalog');
                exit;
            }
        }
    }

    public function PostReviews(ReviewCreateRequest $request)
    {
        $user = $this->authService->getCurrentUser();

        $errors = $request->validate();

        if (empty($errors)) {
            $dto = new ReviewCreateDTO(
                $user,
                $request->getProductId(),
                $request->getComment(),
                $request->getRating()
            );

            $this->reviewService->createReviews($dto);

            header("Location:/reviews?product_id= " . $request->getProductId());
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            header("Location: /reviews?product_id=" . $request->getProductId());
            exit;
        }
    }
}