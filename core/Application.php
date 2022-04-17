<?php

namespace Core;

class Application
{
    public static string $ROOT_DIR;
    public Response $response;
    public static Application $app;
    public Router $router;
    public Request $request;
    public object $redis;

    public function __construct(string $rootDir, array $config)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->redis = Redis::getConnection($config['redis']);
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}