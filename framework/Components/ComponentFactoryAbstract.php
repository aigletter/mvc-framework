<?php


namespace framework\Components;


use framework\Interfaces\ContainerInterface;

abstract class ComponentFactoryAbstract
{
    protected $container;

    protected $params;

    public function __construct(ContainerInterface $container, $params = [])
    {
        $this->container = $container;
        $this->params = $params;
    }

    public function createInstance()
    {
        return $this->getConcrete();
    }

    abstract protected function getConcrete();
}