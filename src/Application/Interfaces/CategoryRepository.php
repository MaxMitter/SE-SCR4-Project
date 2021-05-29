<?php

namespace Application\Interfaces;

interface CategoryRepository {
    public function getCategories() : array;
    public function getCategoryById($categoryId) : array;
}