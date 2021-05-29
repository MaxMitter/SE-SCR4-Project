<?php

namespace Application;

class ProductsQuery {
    public function __construct (
        private Interfaces\ProductRepository $productRepository,
    ) {
    }

    public function execute (string $categoryId) : array {
        $res = [];
        foreach ($this->productRepository->getProductsForCategory($categoryId) as $p) {
            $res[] = new ProductData($p->getProcuctId(), $p->getName(), $p->getInfo(), $p->getCategoryName(), $p->getProducerName(), $p->getUserId(), $p->getRating());
        }
        return $res;
    }
}