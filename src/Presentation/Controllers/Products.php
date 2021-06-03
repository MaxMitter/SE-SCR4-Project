<?php

namespace Presentation\Controllers;

class Products extends \Presentation\MVC\Controller {
    const PARAM_CATEGORY_ID = 'cid';
    const PARAM_PRODUCT_ID = 'pid';
    const PARAM_FILTER = 'f';

    //Param for creation/editing
    const PARAM_EDIT_ID = 'eId';
    const PARAM_CREATE_NAME = 'cname';
    const PARAM_CREATE_INFO = 'cinfo';
    const PARAM_CREATE_PRODUCER = 'cproducer';
    const PARAM_CREATE_CATEGORY = 'ccategory';
    const PARAM_CREATE_ERROR = 'cerr';

    public function __construct(
        private \Application\CategoriesQuery $categoriesQuery,
        private \Application\ProductsQuery $productsQuery,
        private \Application\ProductQuery $productQuery,
        private \Application\ProductSearchQuery $productSearchQuery,
        private \Application\UserQuery $userQuery,
        private \Application\ReviewByProductQuery $reviewQuery,
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\ProducerQuery $producerQuery,
        private \Application\CreateProductCommand $createProductQuery,
        private \Application\EditProductCommand $editProductCommand,
        private \Application\DeleteProductCommand $deleteProductCommand
    ) {

    }

    public function GET_Index(): \Presentation\MVC\ActionResult {
        return $this->view('productlist', [
            'categories' => $this->categoriesQuery->execute(),
            'selectedCategoryId' => $this->tryGetParam(self::PARAM_CATEGORY_ID, $value) ? $value : null,
            'products' => $this->tryGetParam(self::PARAM_CATEGORY_ID, $value) ? $this->productsQuery->execute($value) : null,
            'context' => $this->getRequestUri(),
            'user' => $this->signedInUserQuery->execute()
        ]);
    }

    public function GET_Product(): \Presentation\MVC\ActionResult {
        $product = $this->tryGetParam(self::PARAM_PRODUCT_ID, $value) ? $this->productQuery->execute($value) : null;
        $user = $this->userQuery->execute($product[0]->getUserId());
        $reviewArray = $this->getReviewsInArray($product[0]->getProductId());
        $currentUser = $this->signedInUserQuery->execute();

        return $this->view('productView', [
            'product' => $product[0],
            'userName' => $user->getUserName(),
            'reviews' => $reviewArray,
            'context' => $this->getRequestUri(),
            'user' => $currentUser,
            'canEdit' => (($currentUser != null) ? $currentUser->getId() : -1) === $user->getId(),
            'errors' => [$this->tryGetParam(self::PARAM_CREATE_ERROR, $value) ? $value : null]
        ]);
    }

    public function GET_Search(): \Presentation\MVC\ActionResult {
        $products = $this->tryGetParam(self::PARAM_FILTER, $value) ? $this->productSearchQuery->execute($value) : null;

        return $this->view('productsearch', [
            'products' => $products,
            'filter' => $this->tryGetParam(self::PARAM_FILTER, $value) ? $value : null,
            'context' => $this->getRequestUri(),
            'user' => $this->signedInUserQuery->execute()
        ]);
    }

    public function GET_NewProduct(): \Presentation\MVC\ActionResult {
        $this->tryGetParam(self::PARAM_EDIT_ID, $value);
        if ($value == null) { // create new Product
            $producers = $this->producerQuery->execute();
            $categories = $this->categoriesQuery->execute();

            return $this->view('newProduct', [
                'producers' => $producers,
                'categories' => $categories,
                'user' => $this->signedInUserQuery->execute()
            ]);
        } else { // edit existing product
            $producers = $this->producerQuery->execute();
            $categories = $this->categoriesQuery->execute();

            return $this->view('newProduct', [
                'isEdit' => true,
                'eId' => $this->getParam(self::PARAM_EDIT_ID),
                'producers' => $producers,
                'categories' => $categories,
                'user' => $this->signedInUserQuery->execute(),
                'name' => $this->getParam(self::PARAM_CREATE_NAME),
                'info' => $this->getParam(self::PARAM_CREATE_INFO),
                'cproducer' => $this->getParam(self::PARAM_CREATE_PRODUCER),
                'ccategory' => $this->getParam(self::PARAM_CREATE_CATEGORY)
            ]);
        }
    }

    public function GET_Edit(): \Presentation\MVC\ActionResult {
        $productId = $this->getParam(self::PARAM_EDIT_ID);
        $name = $this->getParam(self::PARAM_CREATE_NAME);
        $info = $this->tryGetParam(self::PARAM_CREATE_INFO, $value) ? $value : "";
        $producerId = $this->getParam(self::PARAM_CREATE_PRODUCER);
        $categoryId = $this->getParam(self::PARAM_CREATE_CATEGORY);
        $user = $this->signedInUserQuery->execute();

        $this->editProductCommand->execute($productId, $name, $info, $producerId, $categoryId);

        return $this->redirect('Products', 'Product', array('pid' => $productId));
    }

    public function GET_Delete(): \Presentation\MVC\ActionResult {
        $productId = $this->getParam(self::PARAM_PRODUCT_ID);
        $this->deleteProductCommand->execute($productId);

        return $this->redirect('Home', 'Index');
    }

    public function GET_Create(): \Presentation\MVC\ActionResult {
        $name = $this->getParam(self::PARAM_CREATE_NAME);
        $info = $this->tryGetParam(self::PARAM_CREATE_INFO, $value) ? $value : "";
        $producerId = $this->getParam(self::PARAM_CREATE_PRODUCER);
        $categoryId = $this->getParam(self::PARAM_CREATE_CATEGORY);
        $user = $this->signedInUserQuery->execute();

        $newProduct = new \Application\Entities\Product(-1, $name, $info, $categoryId, $producerId, $user->getId());
        $productId = $this->createProductQuery->execute($newProduct);

        return $this->redirect('Products', 'Product', array('pid' => $productId));
    }

    private function getReviewsInArray(int $productId): array {
        $reviews = $this->reviewQuery->execute($productId);
        $reviewArray = [];

        foreach ($reviews as $review) {
            $reviewUser = $this->userQuery->execute($review->getUserId());
            $currentUser = $this->signedInUserQuery->execute();
            array_push($reviewArray, [
                'reviewId' => $review->getReviewId(),
                'userName' => $reviewUser->getUserName(),
                'dateTime' => $review->getDateTime(),
                'text' => $review->getText(),
                'value' => $review->getValue(),
                'user' => $currentUser,
                'canEdit' => (($currentUser != null) ? $currentUser->getId() : -1) === $reviewUser->getId()
            ]);
        }

        return $reviewArray;
    }
}