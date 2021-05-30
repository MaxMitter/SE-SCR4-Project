<?php

namespace Application;

class ProductQuery {
    public function __construct(
        private Interfaces\ProductRepository $productRepository
    ) { }

    public function execute (int $productId) : array {
        $res = [];
        foreach ($this->productRepository->getProductById($productId) as $p) {
            $res[] = new ProductData($p->getProductId(), $p->getName(), $p->getInfo(), $p->getCategoryName(), $p->getProducerName(), $p->getUserId(), $p->getRating());
        }
        return $res;
    }
}