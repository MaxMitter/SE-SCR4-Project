<?php

namespace Application;

class EditReviewCommand {
    public function __construct (
        private \Application\Interfaces\ReviewRepository $reviewRepository
    ) { }

    public function execute(int $id, string $text, int $rating): int {
        return $this->reviewRepository->editReview($id, $text, $rating);
    }
}