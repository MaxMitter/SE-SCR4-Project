<?php

namespace Application;

class CheckOutCommand {

    const Error_NotAuthenticated = 0x01;
    const Error_CartEmpty = 0x02;
    const Error_InvalidCreditCardName = 0x04;
    const Error_InvalidCreditCardNumber = 0x08;
    const Error_CreateOrderFailed = 0x10;

    public function __construct(
        private Services\AuthenticationService $authService,
        private Services\CartService $cartService,
        private Interfaces\OrderRepository $orderRepository
    ) {}

    public function execute(string $creditCardName, string $creditCardNumber, ?string &$orderId) : int {
        $creditCardName = trim($creditCardName);
        $creditCardNumber = str_replace(' ', '', $creditCardNumber);

        $errors = 0;

        $userId = $this->authService->getUserId();

        if ($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }

        $cart = $this->cartService->getBooksWithCount();
        if (sizeof($cart) == 0) {
            $errors |= self::Error_CartEmpty;
        }

        if (strlen($creditCardName) == 0) {
            $errors |= self::Error_InvalidCreditCardName;
        }
        if (strlen($creditCardNumber) != 16 || !ctype_digit($creditCardNumber)) {
            $errors |= self::Error_InvalidCreditCardNumber;
        }

        if (!$errors) {
            $orderId = $this->orderRepository->createOrder($userId, $cart, $creditCardName, $creditCardNumber);
            if ($orderId === null) {
                $errors |= Error_CreateOrderFailed;
            } else {
                $this->cartService->clear();
            }
        }

        return $errors;
    }
}