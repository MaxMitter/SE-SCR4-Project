<?php

namespace Application;

class EditProductCommand {
    public function __construct (
        private \Application\Interfaces\ProductRepository $productRepository
    ) {}

    public function execute(int $productId, string $name, string $info, int $producerId, int $categoryId) {
        $this->productRepository->editProduct($productId, $name, $info, $producerId, $categoryId);
    }
}