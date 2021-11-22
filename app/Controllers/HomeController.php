<?php


namespace app\Controllers;


use app\Components\Math\Math;
use framework\Application;
use framework\Interfaces\CacheInterface;
use framework\Interfaces\RouteInterface;
use Learning\MVC\Controller\ControllerInterface;

class HomeController implements ControllerInterface
{
    public function __construct(CacheInterface $cache, Math $math, RouteInterface $route)
    {
       /* $app = Application::getInstance();
        $app->cache->put('test', 'Hello world!!!!!');

        $app->route();*/

        /** @var CacheInterface $cache */
        /*$cache = Application::getInstance()->get('cache');
        $cache = Application::getInstance()->getCache();
        $cache->put('test', 'Hello world!!!!!!!');*/
        $t = '';
    }

    public function index()
    {
        $cache = Application::getInstance()->get('cache');
        echo $cache->get('test');

        $math = Application::getInstance()->get('math');
        echo $math->sum(5, 8);
    }
}