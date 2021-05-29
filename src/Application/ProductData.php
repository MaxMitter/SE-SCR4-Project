<?php

namespace Application;

class ProductData {
    public function __construct (
        private int $productId,
        private string $name,
        private string $info,
        private string $categoryName,
        private string $producerName,
        private int $userId,
        private float $rating
    ) { }

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @return string
     */
    public function getProducerName(): string
    {
        return $this->producerName;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }
}