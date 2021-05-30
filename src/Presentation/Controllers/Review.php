<?php

namespace Presentation\Controllers;

class Review extends \Presentation\MVC\Controller {
    const PARAM_CREATE_TEXT = 'ctext';
    const PARAM_CREATE_RATING = 'crating';
    const PARAM_CREATE_PRODUCTID = 'cproductId';
    const PARAM_CREATE_USERID = 'cuserId';

    public function __construct(
        private \Application\CreateReviewCommand $createReviewCommand
    ) { }

    public function GET_NewReview() : \Presentation\MVC\ActionResult {
        $text = $this->getParam(self::PARAM_CREATE_TEXT);
        $rating = $this->getParam(self::PARAM_CREATE_RATING);
        $productId = $this->getParam(self::PARAM_CREATE_PRODUCTID);
        $userId = $this->getParam(self::PARAM_CREATE_USERID);

        if(!$this->createReviewCommand->execute($text, $rating, $productId, $userId)) {
            return $this->redirect('Products', 'Product', array('pid' => $productId, 'cerr' => 'Creating review failed, please try again'));
        } else {
            return $this->redirect('Products', 'Product', array('pid' => $productId));
        }
    }
}