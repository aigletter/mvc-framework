<?php

/**
 * @var app\Components\ConfiguredRouter\Router $this
 */

use app\Controllers\ProductController;

/*$this->addRoute('GET', '/', function () {
    echo 'Test function handler<br>';
});*/
$this->addRoute('GET', '/', [\app\Controllers\HomeController::class, 'index']);

$string1 = ProductController::class;
$string2 = 'app\Controllers\ProductController';

$this->addRoute('GET', '/product/test/hello/world/todo', [ProductController::class, 'test']);
//$this->addRoute('POST', '/order/craete', [\app\Controllers\ProductController::class, 'create']);