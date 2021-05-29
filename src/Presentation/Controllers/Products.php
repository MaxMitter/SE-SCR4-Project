<?php

namespace Presentation\Controllers;

use Application\CategoryQuery;

class Products extends \Presentation\MVC\Controller {
    const PARAM_CATEGORY_ID = 'cid';
    const PARAM_PRODUCT_ID = 'pid';
    const PARAM_FILTER = 'f';
    const PARAM_BREAKCRUMB = 'brcr';

    public function __construct(
        private \Application\CategoriesQuery $categoriesQuery,
        private \Application\ProductsQuery $productsQuery,
        private \Application\ProductQuery $productQuery,
        private \Application\ProductSearchQuery $productSearchQuery,
        private \Application\UserQuery $userQuery,
        private \Application\ReviewByProductQuery $reviewQuery
    ) {

    }

    public function GET_Index(): \Presentation\MVC\ActionResult {
        return $this->view('productlist', [
            'categories' => $this->categoriesQuery->execute(),
            'selectedCategoryId' => $this->tryGetParam(self::PARAM_CATEGORY_ID, $value) ? $value : null,
            'products' => $this->tryGetParam(self::PARAM_CATEGORY_ID, $value) ? $this->productsQuery->execute($value) : null,
            'context' => $this->getRequestUri(),
            'breadcrumb' => $this->tryGetParam(self::PARAM_BREAKCRUMB, $value) ? $value : null
        ]);
    }

    public function GET_Product(): \Presentation\MVC\ActionResult {
        $product = $this->tryGetParam(self::PARAM_PRODUCT_ID, $value) ? $this->productQuery->execute($value) : null;
        $user = $this->userQuery->execute($product[0]->getUserId());
        $reviews = $this->reviewQuery->execute($product[0]->getProductId());
        $reviewArray = [];
        foreach ($reviews as $review) {
            $reviewUser = $this->userQuery->execute($review->getUserId());
            array_push($reviewArray, [
                'userName' => $reviewUser->getUserName(),
                'dateTime' => $review->getDateTime(),
                'text' => $review->getText(),
                'value' => $review->getValue()]);
        }

        return $this->view('productView', [
            'product' => $product[0],
            'userName' => $user->getUserName(),
            'reviews' => $reviewArray,
            'context' => $this->getRequestUri(),
            'breadcrumb' => $this->tryGetParam(self::PARAM_BREAKCRUMB, $value) ? $value : null
        ]);
    }

    public function GET_Search(): \Presentation\MVC\ActionResult {
        $products = $this->tryGetParam(self::PARAM_FILTER, $value) ? $this->productSearchQuery->execute($value) : null;

        return $this->view('productsearch', [
            'products' => $products,
            'filter' => $this->tryGetParam(self::PARAM_FILTER, $value) ? $value : null,
            'context' => $this->getRequestUri(),
            'breadcrumb' => $this->tryGetParam(self::PARAM_BREAKCRUMB, $value) ? $value : null
        ]);
    }
}