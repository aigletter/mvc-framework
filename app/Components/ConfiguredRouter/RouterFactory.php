<?php


namespace app\Components\ConfiguredRouter;


use framework\Components\ComponentFactoryAbstract;

class RouterFactory extends ComponentFactoryAbstract
{

    protected function getConcrete()
    {
        return new Router();
    }
}