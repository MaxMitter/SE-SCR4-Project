<?php

namespace Application;

class BookSearchQuery {
    public function __construct (
        private Interfaces\BookRepository $bookRepository,
        private Services\CartService $cartService) {

    }

    public function execute (string $filter) {
        $cart = $this->cartService->getBooksWithCount();
        $res = [];
        foreach($this->bookRepository->getBooksForFilter($filter) as $b) {
            $res[] = new BookData($b->getId(), $b->getTitle(), $b->getAuthor(), $b->getPrice(), $cart[$b->getId()] ?? 0);
        }
        return $res;
    }
}