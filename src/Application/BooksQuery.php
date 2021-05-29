<?php
//
//
//namespace Application;
//
//class BooksQuery {
//    public function __construct(private Interfaces\BookRepository $bookRepository,
//                                private Services\CartService $cartService) {
//
//    }
//
//    public function execute (string $categoryId): array {
//        $cart = $this->cartService->getBooksWithCount();
//        $res = [];
//        foreach($this->bookRepository->getBooksForCategory($categoryId) as $b) {
//            $res[] = new BookData($b->getId(), $b->getTitle(), $b->getAuthor(), $b->getPrice(), $cart[$b->getId()] ?? 0);
//        }
//        return $res;
//    }
//}