<?php

namespace app\Components\ConfiguredRouter;

use app\Controllers\HomeController;
use framework\Application;
use framework\Interfaces\RouteInterface;

class Router implements RouteInterface
{
    protected $routes;

    public function __construct()
    {
        include dirname(__DIR__, 3) . '/routes/web.php';
    }

    public function addRoute(string $method, string $path, callable $handler)
    {
        $this->routes[$method][$path] = $handler;
    }


    public function route(): callable
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($this->routes[$method][$path])) {
            return function () use ($method, $path) {
                $action =  $this->routes[$method][$path];
                if (is_string($action[0])) {
                    $className = $action[0];
                    /*$instance = new $className();*/
                    $instance = Application::getInstance()->make($className);
                    return $instance->{$action[1]}();
                }
            };
        }

        throw new \Exception('Route not found');
    }
}