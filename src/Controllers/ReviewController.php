<?php

declare(strict_types=1);

namespace Controllers;

use DTO\ReviewCreateDTO;

use Model\Product;
use Model\Review;

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

    public function getReviews(): void
    {
        if (!isset($_GET['product_id'])) {
            header('Location: /catalog');
            exit;
        }
        $product_id = $_GET['product_id'];

        if ($product_id) {
            if ($this->authService->check()) {
                $user = $this->authService->getCurrentUser();
                $product = Product::getById((int)$product_id);
                if ($product) {
                    $reviewsList = Review::getReviewsByProductId((int)$product_id);
                    require_once '../Views/reviews_page.php';
                } else {
                    header('Location: /catalog');
                    exit;
                }
            } else {
                header('Location: /login');
                exit;
            }
        }
    }

    public function postReviews(ReviewCreateRequest $request): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit;
        }

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

            header("Location: /reviews?product_id=" . $request->getProductId());
            exit;
        } else {
            $_SESSION['errors'] = $errors;
            header("Location: /reviews?product_id=" . $request->getProductId());
            exit;
        }
    }
}