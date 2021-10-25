<?php


namespace framework\Components\Router;


use app\Controllers\HomeController;
use framework\Components\Router\Exceptions\RouteException;
use framework\Interfaces\RouteInterface;

class Router implements RouteInterface
{
    public function route(): callable
    {
        if ($_SERVER['REQUEST_URI'] === '/') {
            $controllerName = HomeController::class;
            $controller = new $controllerName();
            return [$controller, 'index'];
        }

        $parts = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if (!isset($parts[1])) {
            throw new RouteException();
        }
        $controllerName = 'app\\Controllers\\' . ucfirst($parts[1]) . 'Controller';
        $controller = new $controllerName();

        if (!isset($parts[2])) {
            throw new RouteException();
        }
        $method = $parts[2];

        return [$controller, $method];
    }
}