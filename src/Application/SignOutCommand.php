<?php

namespace Application;

class SignOutCommand {
    public function __construct(
        private Services\AuthenticationService $authService,
        private Interfaces\UserRepository $userRepository
    ) { }

    public function execute() : void {
        $this->authService->signOut();
    }
}