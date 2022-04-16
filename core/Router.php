<?php

namespace Core;

class Router
{
    private array $routes = [];
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, mixed $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, mixed $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(): string|null
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callBack = $this->routes[$method][$path] ?? false;

        if($callBack === false){
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }

        if(is_string($callBack)){
            return $this->renderView($callBack);
        }

        if(is_array($callBack)){
            $callBack[0] = new $callBack[0]();
        }

        return call_user_func($callBack, $this->request);
    }

    public function renderView(string $view, array $params = []): string|array|bool
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(): false|string
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/main" . '.php';
        return ob_get_clean();
    }

    protected function renderOnlyView(string $view, array $params): false|string
    {
        foreach ($params as $key => $value){
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/{$view}" . '.php';
        return ob_get_clean();
    }
}