<?php

namespace Presentation\Controllers;

class Review extends \Presentation\MVC\Controller {
    const PARAM_CREATE_TEXT = 'ctext';
    const PARAM_CREATE_RATING = 'crating';
    const PARAM_CREATE_PRODUCTID = 'cproductId';
    const PARAM_CREATE_USERID = 'cuserId';

    //edit params
    const PARAM_EDIT_ID = 'eid';
    const PARAM_EDIT_TEXT = 'etext';
    const PARAM_EDIT_RATING = 'erating';

    public function __construct(
        private \Application\CreateReviewCommand $createReviewCommand,
        private \Application\EditReviewCommand $editReviewCommand,
        private \Application\DeleteReviewCommand $deleteReviewCommand
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

    public function GET_Edit() : \Presentation\MVC\ActionResult {
        $id = $this->getParam(self::PARAM_EDIT_ID);
        $text = $this->getParam(self::PARAM_EDIT_TEXT);
        $rating = $this->getParam(self::PARAM_EDIT_RATING);
        $productId = $this->editReviewCommand->execute($id, $text, $rating);

        return $this->redirect('Products', 'Product', array('pid' => $productId));
    }

    public function GET_Delete(): \Presentation\MVC\ActionResult {
        $rId = $this->getParam(self::PARAM_EDIT_ID);

        $productId = $this->deleteReviewCommand->execute($rId);

        return $this->redirect('Products', 'Product', array('pid' => $productId));
    }
}