<?php

namespace Application;

class CategoryQuery {
    public function __construct(private Interfaces\CategoryRepository $catRepo) { }

    public function execute($categoryId): array {
        $res = [];
        foreach ($this->catRepo->getCategoryById($categoryId) as $c) {
            $res[] = new CategoryData($c->getId(), $c->getName());
        }
        return $res;
    }
}