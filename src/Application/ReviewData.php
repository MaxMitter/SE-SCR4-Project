<?php

namespace Application;

class ReviewData {
    public function __construct (
        private int $reviewId,
        private int $userId,
        private int $productId,
        private string $text,
        private int $value,
        private string $dateTime
    ) { }

    /**
     * @return int
     */
    public function getReviewId(): int
    {
        return $this->reviewId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getDateTime(): string
    {
        return $this->dateTime;
    }

}