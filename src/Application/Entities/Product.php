<?php

namespace Application\Entities;

class Product {
    public function __construct(
        private int $productId,
        private string $name,
        private string $info,
        private int $categoryId,
        private int $producerId,
        private int $userId,
    ) {

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
    public function getName(): string
    {
        return $this->name;
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
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return string
     */
    public function getProducerId(): int
    {
        return $this->producerId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}