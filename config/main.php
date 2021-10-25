<?php

use app\Components\Math\MathFactory;

use framework\Components\Cache\MemoryCacheFactory;

//use app\Components\Router\RouterFactory;
use framework\Components\Router\RouterFactory;

return [
    'app_name' => 'Test framework',
    'components' => [
        'router' => [
            'factory' => RouterFactory::class
            //'factory' => \app\Components\Router\RouterFactory::class,
        ],
        'cache' => [
            'factory' => MemoryCacheFactory::class,
        ],
        'math' => [
            'factory' => MathFactory::class,
        ]
    ],
];