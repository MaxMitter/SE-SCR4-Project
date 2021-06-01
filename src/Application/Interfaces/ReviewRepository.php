<?php

namespace Application\Interfaces;

interface ReviewRepository {
    public function getReviewsByProductId(int $productId) : array;
    public function getReviewsByUserId(int $userId) : array;
    public function createReview(string $text, int $rating, int $productId, int $userId) : int;
    public function editReview(int $id, string $text, int $rating): int;
    public function deleteReview(int $reviewId): int;
}