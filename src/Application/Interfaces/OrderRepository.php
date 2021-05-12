<?php

namespace Application\Interfaces;

interface OrderRepository {
    public function createOrder(int $userId, array $bookIdsWithCount, string $creditCardName, string $creditCardNumber) : ?int;
}