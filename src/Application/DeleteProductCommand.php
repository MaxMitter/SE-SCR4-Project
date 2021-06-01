<?php

namespace Application;

class DeleteProductCommand {
    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository
    ) { }

    public function execute(int $productId) {
        $this->productRepository->deleteProduct($productId);
    }
}