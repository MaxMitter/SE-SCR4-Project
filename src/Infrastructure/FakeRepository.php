<?php

namespace Infrastructure;

class FakeRepository 
implements 
\Application\Interfaces\CategoryRepository,
\Application\Interfaces\BookRepository,
\Application\Interfaces\UserRepository,
\Application\Interfaces\OrderRepository
{
    private $mockCategories;
    private $mockBooks;
    private $mockUsers;

    public function __construct()
    {
        // create mock data
        $this->mockCategories = array(
            array(1, 'Mobile & Wireless Computing'),
            array(2, 'Functional Programming'),
            array(3, 'C / C++'),
            array(4, '<< New Publications >>')
        );

        $this->mockBooks = array(
            array(1, 1, 'Hello, Android:\nIntroducing Google\'s Mobile Development Platform', 'Ed Burnette', 19.97),
            array(2, 1, 'Android Wireless Application Development', 'Shane Conder, Lauren Darcey', 31.22),
            array(5, 1, 'Professional Flash Mobile Development', 'Richard Wagner', 19.90),
            array(7, 1, 'Mobile Web Design For Dummies', 'Janine Warner, David LaFontaine', 16.32),
            array(11, 2, 'Introduction to Functional Programming using Haskell', 'Richard Bird', 74.75),
            // book with title to test scripting attack
            array(12, 2, 'Scripting (Attacks) for Beginners - <script type="text/javascript">alert(\'All your base are belong to us!\');</script>', 'John Doe', 9.99),
            array(14, 2, 'Expert F# (Expert\'s Voice in .NET)', 'Antonio Cisternino, Adam Granicz, Don Syme', 47.64),
            array(16, 3, 'C Programming Language\n(2nd Edition)', 'Brian W. Kernighan, Dennis M. Ritchie', 48.36),
            array(27, 3, 'C++ Primer Plus\n(5th Edition)', 'Stephan Prata', 36.94),
            array(29, 3, 'The C++ Programming Language', 'Bjarne Stroustrup', 67.49)
        );

        $this->mockUsers = array(
            array(1, 'scr4', 'scr4')
        );
    }

    // TODO: implementation

    public function getCategories() : array {
        $res = array();
        foreach ($this->mockCategories as $c) {
            $res[] = new \Application\Entities\Category($c[0], $c[1]);
        }

        return $res;
    }

    public function getBooksForCategory(int $categoryId): array {
        $res = array();
        foreach ($this->mockBooks as $b) {
            if ($b[1] === $categoryId) {
                $res[] = new \Application\Entities\Book($b[0], $b[2], $b[3], $b[4]);
            }
        }
        return $res;
    }

    public function getBooksForFilter(string $filter) : array {
        $res = array();

        foreach ($this->mockBooks as $b) {
            if ($filter == '' || stripos($b[2], $filter) !== false) {
                $res[] = new \Application\Entities\Book($b[0], $b[2], $b[3], $b[4]);
            }
        }
        return $res;
    }

    public function getUserForUserNameAndPassword(string $username, string $password) : ?\Application\Entities\User {
        foreach($this->mockUsers as $u) {
            if ($u[1] == $username && $u[2] == $password) {
                return new \Application\Entities\User($u[0], $u[1]);
            }
        }
        return null;
    }

    public function getUser(int $id) : ?\Application\Entities\User {
        foreach($this->mockUsers as $u) {
            if ($u[0] == $id) {
                return new \Application\Entities\User($u[0], $u[1]);
            }
        }
        return null;
    }

    public function createOrder(int $userId, array $bookIdsWithCount, string $creditCardName, string $creditCardNumber) : ?int {
        return rand();
    }
}
