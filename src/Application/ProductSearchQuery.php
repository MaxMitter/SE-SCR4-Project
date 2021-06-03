<?php

namespace Application;

class ProductSearchQuery {
    public function __construct(
        private Interfaces\ProductRepository $productRepository
    ) { }

    public function execute(string $filter): array
    {
        $res = [];
        foreach($this->productRepository->getProductsForFilter($filter) as $p) {
            $res[] = new ProductData($p->getProductId(), $p->getName(), $p->getInfo(), $p->getCategoryName(), $p->getProducerName(), $p->getUserId(), $p->getRating());
        }
        return $res;
    }
}