<?php

use App\Controllers\HomeController;
use Core\Application;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

$app->router->get('/', [HomeController::class, 'create']);

$app->run();