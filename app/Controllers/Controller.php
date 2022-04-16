<?php

namespace App\Controllers;

use Core\Application;

class Controller
{
    public function render(string $view, array $param = []): bool|array|string
    {
        return Application::$app->router->renderView($view, $param);
    }
}