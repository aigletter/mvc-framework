<?php


namespace app\Components\Router;


use framework\Components\ComponentFactoryAbstract;
use framework\Components\Router\Router;

class RouterFactory extends ComponentFactoryAbstract
{
    protected function getConcrete()
    {
        return new Router();
    }
}