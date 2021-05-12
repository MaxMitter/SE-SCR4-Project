<?php

namespace Application\Interfaces;

interface UserRepository {
    public function getUserForUserNameAndPassword(string $username, string $password) : ?\Application\Entities\User;
    public function getUser(int $id) : ?\Application\Entities\User;
}