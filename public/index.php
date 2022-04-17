<?php

use App\Controllers\HomeController;
use Core\Application;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'redis' => [
        'host' => $_ENV['REDIS_HOST'],
        'password' => $_ENV['REDIS_PASSWORD'],
        'port' => $_ENV['REDIS_PORT'],
        'scheme' => $_ENV['REDIS_SCHEME']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [HomeController::class, 'create']);
$app->router->post('/', [HomeController::class, 'store']);
$app->router->get('/search', [HomeController::class, 'search']);
$app->router->post('/search', [HomeController::class, 'show']);

$app->run();