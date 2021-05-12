<?php

namespace Application;

class CategoriesQuery {
    public function __construct(private Interfaces\CategoryRepository $catRepo) {

    }

    public function execute(): array {
        $res = [];
        foreach ($this->catRepo->getCategories() as $c) {
            $res[] = new CategoryData($c->getId(), $c->getName());
        }

        return $res;
    }
}