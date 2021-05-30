<?php

namespace Application;

class CreateProductQuery {
    public function __construct(
        private Interfaces\ProductRepository $productRepository
    ) { }

    public function execute(\Application\Entities\Product $product) {
        return $this->productRepository->createProduct($product);
    }
}