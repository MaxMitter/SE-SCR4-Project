<?php

namespace Application;

class SignInCommand {
    public function __construct(
        private Services\AuthenticationService $authService,
        private Interfaces\UserRepository $userRepository
    ) { }

    public function execute(string $username, string $password) {
        $this->authService->signOut();
        $user = $this->userRepository->getUserForUserNameAndPassword($username, $password);
        if ($user != null) {
            $this->authService->signIn($user->getid());
            return true;
        }

        return false;
    }
}