<?php


namespace app\Components\Math;


use framework\Interfaces\CacheInterface;

class MathFactory extends \framework\Components\ComponentFactoryAbstract
{

    protected function getConcrete()
    {
        $cache = $this->container->get(CacheInterface::class);
        return new Math($cache, $this->params['test']);
    }
}