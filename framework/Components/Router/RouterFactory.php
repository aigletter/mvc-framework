<?php


namespace framework\Components\Router;


use framework\Components\ComponentFactoryAbstract;

class RouterFactory extends ComponentFactoryAbstract
{
    protected function getConcrete()
    {
        return new Router();
    }
}