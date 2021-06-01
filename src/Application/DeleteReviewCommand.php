<?php

namespace Application;

class DeleteReviewCommand {
    public function __construct(
        private \Application\Interfaces\ReviewRepository $reviewRepository
    ) { }

    public function execute($reviewId) : int {
        return $this->reviewRepository->deleteReview($reviewId);
    }
}