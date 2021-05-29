<?php

namespace Infrastructure;

use Application\Interfaces\ProductRepository;

class Repository
implements
    \Application\Interfaces\ProductRepository,
    \Application\Interfaces\CategoryRepository,
    \Application\Interfaces\OrderRepository,
    \Application\Interfaces\UserRepository,
    \Application\Interfaces\ReviewRepository
{
    private $server;
    private $userName;
    private $password;
    private $database;

    public function __construct(string $server, string $userName, string $password, string $database)
    {
        $this->server = $server;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }

    // === private helper methods ===

    private function getConnection()
    {
        $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
        if (!$con) {
            die('Unable to connect to database. Error: ' . mysqli_connect_error());
        }
        return $con;
    }

    private function executeQuery($connection, $query)
    {
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query': " . $connection->error);
        }
        return $result;
    }

    private function executeStatement($connection, $query, $bindFunc)
    {
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }

    // === public methods ===

    public function getCategories(): array
    {
        $categories = [];
        $con = $this->getConnection();

        $res = $this->executeQuery($con, 'SELECT categoryId, name FROM category');

        while($cat = $res->fetch_object()) {
            $categories[] = new \Application\Entities\Category($cat->categoryId, $cat->name);
        }

        $res->close();
        $con->close();

        return $categories;
    }

    public function getCategoryById($categoryId): array
    {
        $categories = [];
        $con = $this->getConnection();

        $stat = $this->executeStatement(
            $con, 'SELECT categoryId, name FROM category WHERE categoryId = ?',
            function ($s) use ($categoryId) {
                $s->bind_param('i', $categoryId);
            }
        );
        $stat->bind_result($categoryId, $name);

        while($stat->fetch()) {
            $categories[] = new \Application\Entities\Category($cat->categoryId, $cat->name);
        }

        $stat->close();
        $con->close();

        return $categories;
    }


    public function getProductsForCategory(int $categoryId): array
    {
        $products = [];

        $con = $this->getConnection();

        $stat = $this->executeStatement(
            $con,
            'SELECT productId, p.name, info, c.name, pr.name as producerName, p.userId, AVG(value) as rating
                    FROM product p
                    INNER JOIN review r USING (productId)
                    INNER JOIN producer pr USING (producerId)
                    INNER JOIN category c USING (categoryId)
                    WHERE categoryId = ? 
                    GROUP BY productId',
            function ($s) use ($categoryId) {
                $s->bind_param('i', $categoryId);
            }
        );
        $stat->bind_result($productId, $name, $info, $categoryName, $producerName, $userId, $rating);

        while($stat->fetch()) {
            $products[] = new \Application\Entities\Product($productId, $name, $info, $categoryName, $producerName, $userId, $rating);
        }
        $stat->close();
        $con->close();

        return $products;
    }

    public function getProductsForFilter(string $filter): array
    {
        $products = [];

        $con = $this->getConnection();

        if ($filter == '') {
            $stat = $this->executeStatement(
                $con,
                'SELECT productId, p.name, info, c.name, pr.name as producerName, p.userId, AVG(value) as rating
                        FROM product p
                        INNER JOIN review r USING (productId)
                        INNER JOIN producer pr USING (producerId)
                        INNER JOIN category c USING (categoryId)
                        GROUP BY productId',
                function ($s) use ($filter) { }
            );
        } else {
            $filterSql = "%$filter%";
            $stat = $this->executeStatement(
                $con,
                'SELECT productId, p.name, info, c.name, pr.name as producerName, p.userId, AVG(value) as rating
                        FROM product p
                        INNER JOIN review r USING (productId)
                        INNER JOIN producer pr USING (producerId)
                        INNER JOIN category c USING (categoryId)
                        WHERE p.name LIKE ? OR p.info LIKE ?
                        GROUP BY productId',
                function ($s) use ($filterSql) {
                    $s->bind_param('ss', $filterSql, $filterSql);
                }
            );
        }
        $stat->bind_result($productId, $name, $info, $categoryName, $producerName, $userId, $rating);

        while($stat->fetch()) {
            $products[] = new \Application\Entities\Product($productId, $name, $info, $categoryName, $producerName, $userId, $rating);
        }
        $stat->close();
        $con->close();

        return $products;
    }

    public function getProductById(int $productId): array
    {
        $products = [];

        $con = $this->getConnection();

        $stat = $this->executeStatement(
            $con,
            'SELECT productId, p.name, info, c.name, pr.name as producerName, p.userId, AVG(value) as rating
                    FROM product p
                    INNER JOIN review r USING (productId)
                    INNER JOIN producer pr USING (producerId)
                    INNER JOIN category c USING (categoryId)
                    WHERE productId = ? 
                    GROUP BY productId',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($productId, $name, $info, $categoryName, $producerName, $userId, $rating);

        while($stat->fetch()) {
            $products[] = new \Application\Entities\Product($productId, $name, $info, $categoryName, $producerName, $userId, $rating);
        }
        $stat->close();
        $con->close();

        return $products;
    }


    public function getUser(int $id): ?\Application\Entities\User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT userId, name FROM user WHERE userId = ?',
            function($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );
        $stat->bind_result($id, $userName);
        if($stat->fetch()) {
            $user = new \Application\Entities\User($id, $userName);
        }
        $stat->close();
        $con->close();
        return $user;
    }

    public function getUserForUserNameAndPassword(string $userName, string $password): ?\Application\Entities\User
    {
        $user = null;
        $pw = password_hash($password, PASSWORD_DEFAULT);
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT userId, name, passwordHash FROM user WHERE name = ?',
            function($s) use ($userName) {
                $s->bind_param('s', $userName);
            }
        );
        $stat->bind_result($id, $userName, $pwHash);
        if($stat->fetch()) {
            $user = new \Application\Entities\User($id, $userName, $pwHash);
        }
        $stat->close();
        $con->close();
        if ($user != null) {
            if (!password_verify($password,$user->getPwHash()))
                $user = null;
        }
        return $user;
    }

    public function createOrder(int $userId, array $bookIdsWithCount, string $creditCardName, string $creditCardNumber): ?int
    {
        $con = $this->getConnection();
        $con->autocommit(false);

        $stat = $this->executeStatement(
            $con,
            'INSERT INTO orders (userId, creditCardHolder, creditCardNumber) VALUES (?, ?, ?)',
            function ($s) use ($userId, $creditCardName, $creditCardNumber) {
                $s->bind_param('iss', $userId, $creditCardName, $creditCardNumber);
            }
        );

        $orderId = $stat->insert_id;
        $stat->close();

        foreach($bookIdsWithCount as $bookId => $count) {
            for ($i = 0; $i < $count; $i++) {
                $this->executeStatement(
                    $con,
                    'INSERT INTO orderdBooks (orderId, bookId) VALUE (?, ?)',
                    function ($s) use ($orderId, $bookId) {
                        $s->bind_param('ii', $orderId, $bookId);
                    }
                )->close();
            }
        }

        $con->commit();
        $con->close();

        return $orderId;
    }

    public function getReviewsByProductId(int $productId): array
    {
        $reviews = [];

        $con = $this->getConnection();

        $stat = $this->executeStatement(
            $con,
            'SELECT * FROM review WHERE productId = ?',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($reviewId, $userId, $productId, $text, $value, $dateTime);

        while($stat->fetch()) {
            $reviews[] = new \Application\Entities\Review($reviewId, $userId, $productId, $text, $value, $dateTime);
        }
        $stat->close();
        $con->close();

        return $reviews;
    }

    public function getReviewsByUserId(int $userId): array
    {
        $reviews = [];

        $con = $this->getConnection();

        $stat = $this->executeStatement(
            $con,
            'SELECT * FROM review WHERE userId = ?',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($reviewId, $userId, $productId, $text, $value, $dateTime);

        while($stat->fetch()) {
            $reviews[] = new \Application\Entities\Review($reviewId, $userId, $productId, $text, $value, $dateTime);
        }
        $stat->close();
        $con->close();

        return $reviews;
    }


}
