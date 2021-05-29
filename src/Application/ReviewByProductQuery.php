<?php

namespace Application;

class ReviewByProductQuery {
    public function __construct(
        private Interfaces\ReviewRepository $reviewRepository
    ) { }

    public function execute(int $productId) : array {
        $res = [];
        foreach ($this->reviewRepository->getReviewsByProductId($productId) as $r) {
            $res[] = new ReviewData($r->getReviewId(), $r->getUserId(), $r->getProductId(), $r->getText(), $r->getValue(), $r->getDateTime());
        }
        return $res;
    }
}