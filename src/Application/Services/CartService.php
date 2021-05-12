<?php

namespace Application\Services;

class CartService {
    const SESSION_CART = 'cart';

    public function __construct(private \Application\Interfaces\Session $session) {

    }

    public function getBooksWithCount() : array {
        return $this->getOrCreateCart();
    }

    public function getSize() : int {
        $size = 0;
        foreach($this->getOrCreateCart() as $bookId => $count) {
            $size += $count;
        }

        return $size;
    }

    public function addBook(int $bookId) : void {
        $cart = $this->getOrCreateCart();

        if (!isset($cart[$bookId])) {
            $cart[$bookId] = 1;
        } else {
            $cart[$bookId]++;
        }

        $this->session->put(self::SESSION_CART, $cart);
    }

    public function removeBook(int $bookId) : void {
        $cart = $this->getOrCreateCart();

        if (isset($cart[$bookId])) {
            if ($cart[$bookId] > 1) {
                $cart[$bookId]--;
            } else {
                unset($cart[$bookId]);
            }
        }

        $this->session->put(self::SESSION_CART, $cart);
    }

    public function clear() : void {
        $this->session->delete(self::SESSION_CART);
    }

    private function getOrCreateCart() : array {
        return $this->session->get(self::SESSION_CART) ?? [];
    }
}