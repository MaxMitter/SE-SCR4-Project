<?php

namespace Application;

class RegisterCommand {
    public function __construct(
        private Services\AuthenticationService $authenticationService,
        private Interfaces\UserRepository $userRepository
    ) { }

    public function execute(string $username, string $password): bool
    {
        $this->authenticationService->signOut();
        $user = $this->userRepository->createNewUser($username, $password);
        if ($user != null) {
            $this->authenticationService->signIn($user->getid());
            return true;
        }
        return false;
    }
}