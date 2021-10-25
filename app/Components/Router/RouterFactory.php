<?php


namespace app\Components\Router;


use framework\Components\ComponentFactoryAbstract;
use Learning\MVC\Routing\Router;

class RouterFactory extends ComponentFactoryAbstract
{
    protected function getConcrete()
    {
        return new Router();
    }
}