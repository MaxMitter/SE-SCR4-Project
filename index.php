<?php
// === register autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

// TODO: handle request
$sp = new \ServiceProvider();

// --- Infrastructure
$sp->register(\Infrastructure\Session::class, isSingleton: true);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);
//$sp->register(\Infrastructure\FakeRepository::class, isSingleton: true);
$sp->register(\Infrastructure\Repository::class, function() {
    return new \Infrastructure\Repository('localhost', 'root', '', 'productreviews');
}, isSingleton: true);
$sp->register(\Application\Interfaces\CategoryRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\ProductRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\OrderRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\ReviewRepository::class, \Infrastructure\Repository::class);

// --- Application
$sp->register(\Application\CategoriesQuery::class);
$sp->register(\Application\CategoryQuery::class);
$sp->register(\Application\ProductsQuery::class);
$sp->register(\Application\ProductQuery::class);
$sp->register(\Application\UserQuery::class);
$sp->register(\Application\ReviewByProductQuery::class);
$sp->register(\Application\ProductSearchQuery::class);
$sp->register(\Application\AddBookToCartCommand::class);
$sp->register(\Application\RemoveBookFromCartCommand::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\CartSizeQuery::class);
$sp->register(\Application\CheckOutCommand::class);

// --- Services
$sp->register(\Application\Services\CartService::class);
$sp->register(\Application\Services\AuthenticationService::class);

// --- Presentation
// MVC Framework
$sp->register(\Presentation\MVC\MVC::class, function() {
    return new \Presentation\MVC\MVC();
}, isSingleton: true);

// Controllers
$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\Products::class);
$sp->register(\Presentation\Controllers\Cart::class);
$sp->register(\Presentation\Controllers\User::class);
$sp->register(\Presentation\Controllers\Order::class);

// --- handle Request
$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);