<?php

use app\Components\Math\MathFactory;

use framework\Components\Cache\MemoryCacheFactory;

//use app\Components\Router\RouterFactory;
use framework\Components\Router\RouterFactory;

return [
    'app_name' => 'Test framework',
    'components' => [
        \framework\Interfaces\RouteInterface::class => [
            'factory' => \app\Components\ConfiguredRouter\RouterFactory::class,
            //'factory' => RouterFactory::class
            //'factory' => \app\Components\Router\RouterFactory::class,
            'aliases' => [
                'router'
            ]
        ],
        \framework\Interfaces\CacheInterface::class => [
            'factory' => MemoryCacheFactory::class,
            'aliases' => [
                'cache'
            ]
        ],
        \app\Components\Math\Math::class => [
            //'factory' => MathFactory::class,
            'class' => \app\Components\Math\Math::class,
            'aliases' => ['math'],
            'params' => [
                'test' => 'hello',
                'count' => 100,
            ]
        ]
    ],
];