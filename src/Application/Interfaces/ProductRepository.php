<?php

namespace Application\Interfaces;

interface ProductRepository {
    public function getProductsForCategory(int $categoryId) : array;
    public function getProductsForFilter(string $filter) : array;
    public function getProductById(int $productId) : array;
    public function createProduct(\Application\Entities\Product $productData): int;
}