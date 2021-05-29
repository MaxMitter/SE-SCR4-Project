<?php

namespace Application\Interfaces;

interface ReviewRepository {
    public function getReviewsByProductId(int $productId) : array;
    public function getReviewsByUserId(int $userId) : array;
}