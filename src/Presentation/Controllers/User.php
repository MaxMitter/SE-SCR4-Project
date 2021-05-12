<?php

namespace Presentation\Controllers;

class User extends \Presentation\MVC\Controller {

    const PARAM_USER_NAME = 'un';
    const PARAM_PASSWORD = 'pwd';

    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\SignInCommand $signInCommand,
        private \Application\SignOutCommand $signOutCommand
    ) { }

    public function GET_LogIn() : \Presentation\MVC\ActionResult {
        $user = $this->signedInUserQuery->execute();
        if ($user != null) {
            return $this->redirect('Home', 'Index');
        }
        return $this->view('login', [
            'user' => $user,
            'userName' => $this->tryGetParam(self::PARAM_USER_NAME, $value) ? $value : ""
        ]);
    }

    public function POST_LogIn() : \Presentation\MVC\ActionResult {
        if (!$this->signInCommand->execute($this->getParam(self::PARAM_USER_NAME), $this->getParam(self::PARAM_PASSWORD))) {
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam(self::PARAM_USER_NAME),
                'errors' => ['Invalid Username or password']
            ]);
        }
        return $this->redirect('Home', 'Index');
    }

    public function POST_LogOut() : \Presentation\MVC\ActionResult {
        $this->signOutCommand->execute();
        return $this->redirect('Home', 'Index');
    }
}