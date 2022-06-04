<?php
namespace app\core;

class Application
{
    // Generally, objects like router, request, database, connection should be always a part of our application so we can access it from everywhere

    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    // Echo is in one place only
    public function run()
    {
        echo $this->router->resolve();
    }
}