<?php

namespace Presentation\Controllers;

class Cart extends \Presentation\MVC\Controller {
    const PARAM_BOOK_ID = 'bid';
    const PARAM_CONTEXT = 'ctx';

    public function __construct(private \Application\AddBookToCartCommand $addCommand,
                                private \Application\RemoveBookFromCartCommand $removeCommand) {

    }

    public function POST_Add() : \Presentation\MVC\ActionResult {
        $this->addCommand->execute($this->getParam(self::PARAM_BOOK_ID));
        return $this->redirectToUri($this->getParam(self::PARAM_CONTEXT));
    }

    public function POST_Remove() : \Presentation\MVC\ActionResult {
        $this->removeCommand->execute($this->getParam(self::PARAM_BOOK_ID));
        return $this->redirectToUri($this->getParam(self::PARAM_CONTEXT));
    }
}