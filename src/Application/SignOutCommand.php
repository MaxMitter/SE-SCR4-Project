<?php

namespace Application;

class SignOutCommand {
    public function __construct(
        private Services\AuthenticationService $authService
    ) { }

    public function execute() : void {
        $this->authService->signOut();
    }
}