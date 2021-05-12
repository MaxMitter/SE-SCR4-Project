<?php

namespace Presentation\Controllers;

class Order extends \Presentation\MVC\Controller {

    const PARAM_NAME_ON_CARD = 'noc';
    const PARAM_CARD_NUMBER = 'cn';
    const PARAM_ORDER_ID = 'oid';

    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\CartSizeQuery $cartSizeQuery,
        private \Application\CheckOutCommand $checkOutCommand
    ) { }

    public function POST_Create() : \Presentation\MVC\ActionResult {
        $ccName = $this->getParam(self::PARAM_NAME_ON_CARD);
        $ccNumber = $this->getParam(self::PARAM_CARD_NUMBER);
        $result = $this->checkOutCommand->execute($ccName, $ccNumber, $orderId);

        if ($result != null) {
            if ($result & \Application\CheckOutCommand::Error_NotAuthenticated) {
                return $this->redirect('Order', 'Create'); // let according GET action handle this
            }
            if ($result & \Application\CheckOutCommand::Error_CartEmpty) {
                return $this->redirect('Order', 'Create'); // let according GET action handle this
            }
                $errors = [];
            if ($result & \Application\CheckOutCommand::Error_InvalidCreditCardName) {
                $errors[] = 'Invalid name on card.';
            }
            if ($result & \Application\CheckOutCommand::Error_InvalidCreditCardNumber) {
                $errors[] = 'Invalid card number. Card number must be sixteen digits.';
            }
            if (sizeof($errors) == 0) {
                $errors[] = 'Order creation failed.';
            }
            return $this->view('orderForm', [
                'user' => $this->signedInUserQuery->execute(),
                'cartSize' => $this->cartSizeQuery->execute(),
                'nameOnCard' => $ccName,
                'cardNumber' => $ccNumber,
                'error' => $errors
            ]);
        } else {
            return $this->redirect('Order', 'ShowSummary', [self::PARAM_ORDER_ID => $orderId]);
        }
    }

    public function GET_Create() : \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->redirect('User', 'Login');
        }

        $cartSize = $this->cartSizeQuery->execute();
        if ($cartSize == 0) {
            return $this->view('orderFormEmptyCart', [
                'user' => $user
            ]);
        }

        return $this->view('orderForm', [
            'user' => $user,
            'cartSize' => $cartSize,
            'nameOnCard' => $this->tryGetParam(self::PARAM_NAME_ON_CARD, $value) ? $value : "",
            'cardNumber' => $this->tryGetParam(self::PARAM_CARD_NUMBER, $value) ? $value : "",
        ]);
    }

    public function GET_ShowSummary() : \Presentation\MVC\ActionResult {
        return $this->view('orderSummary', [
            'user' => $this->signedInUserQuery->execute(),
            'orderId' => $this->getParam(self::PARAM_ORDER_ID)
        ]);
    }
}