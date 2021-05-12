<?php

namespace Presentation\Controllers;

class Books extends \Presentation\MVC\Controller {
    const PARAM_CATEGORY_ID = 'cid';
    const PARAM_FILTER = 'f';

    public function __construct(
        private \Application\CategoriesQuery $categoriesQuery,
        private \Application\BooksQuery $booksQuery,
        private \Application\BookSearchQuery $bookSearchQuery
    ) {

    }

    public function GET_Index(): \Presentation\MVC\ActionResult {
        return $this->view('booklist', [
            'categories' => $this->categoriesQuery->execute(),
            'selectedCategoryId' => $this->tryGetParam(self::PARAM_CATEGORY_ID, $value) ? $value : null,
            'books' => $this->tryGetParam(self::PARAM_CATEGORY_ID, $value) ? $this->booksQuery->execute($value) : null,
            'context' => $this->getRequestUri()
        ]);
    }

    public function GET_Search() : \Presentation\MVC\ActionResult {
        return $this->view('booksearch', [
            'books' => $this->tryGetParam(self::PARAM_FILTER, $value) ? $this->bookSearchQuery->execute($value) : null,
            'filter' => $this->tryGetParam(self::PARAM_FILTER, $value) ? $value : null,
            'context' => $this->getRequestUri()
        ]);
    }
}