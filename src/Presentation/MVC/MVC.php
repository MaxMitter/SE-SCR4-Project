<?php

namespace Presentation\MVC;

use Exception;

final class MVC
{
    public function __construct(
        private string $viewPath = 'views/',
        private string $controllerNamespace = 'Presentation\\Controllers',
        private string $defaultController = 'Home',
        private string $defaultAction = 'Index',
        private string $controllerParameterName = 'c',
        private string $actionParameterName = 'a',
    ) {
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }

    public function getControllerParameterName(): string
    {
        return $this->controllerParameterName;
    }

    public function getActionParameterName(): string
    {
        return $this->actionParameterName;
    }

    public function buildActionLink(?string $controller = null, ?string $action, array $params = []): string
    {
        $res = '?' . $this->controllerParameterName . '=' . rawurlencode($controller ?? $this->defaultController) . '&' . $this->actionParameterName . '=' . rawurlencode($action ?? $this->defaultAction);
        foreach ($params as $name => $value) {
            $res .= '&' . rawurlencode($name) . '=' . rawurlencode($value);
        }
        return $res;
    }

    public function handleRequest(\ServiceProvider $serviceProvider): void
    {
        // determine controller class
        $controllerName = $_REQUEST[$this->controllerParameterName] ?? $this->defaultController;
        $controller = $this->controllerNamespace . "\\$controllerName";
        // determine HTTP method and action
        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_REQUEST[$this->actionParameterName] ?? $this->defaultAction;
        // instanciate controller and call according action method
        $m = $method . '_' . $action;
        if (!method_exists($serviceProvider->resolve($controller), $m)) {
            http_response_code(404);
            include('views/404.html');
            die();
        }
        $res = $serviceProvider->resolve($controller)->$m();
        if (!is_a($res, ActionResult::class)) {
            //throw new Exception("Return value of controller action '$controllerName:$m' is not an instance of ActionResult.");
            http_response_code(404);
            include('views/404.html');
            die();
        }
        // handle result
        $res->handle($this);
    }
}
