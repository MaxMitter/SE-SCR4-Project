<?php

namespace Application;

class CreateReviewCommand {
    public function __construct(
        private \Application\Interfaces\ReviewRepository $reviewRepository
    ) { }

    public function execute(string $text, int $rating, int $productId, int $userId): bool {
        $reviewId = $this->reviewRepository->createReview($text, $rating, $productId, $userId);
        if ($reviewId != null) {
            return true;
        }
        return false;
    }
}