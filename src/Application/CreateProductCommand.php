<?php

namespace Application;

class CreateProductCommand {
    public function __construct(
        private Interfaces\ProductRepository $productRepository
    ) { }

    public function execute(\Application\Entities\Product $product):int {
        return $this->productRepository->createProduct($product);
    }
}