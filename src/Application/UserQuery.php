<?php

namespace Application;

class UserQuery
{
    public function __construct(
        private Interfaces\UserRepository $userRepository
    )
    {
    }

    public function execute(int $userId) {
        $user = $this->userRepository->getUser($userId);
        return new UserData($userId, $user->getUserName());
    }
}