<?php

declare(strict_types=1);

ini_set('display_errors', '1');

include $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

$app = \framework\Application::getInstance();

$config = include __DIR__ . '/../config/main.php';
$app->configure($config);

$app->run();