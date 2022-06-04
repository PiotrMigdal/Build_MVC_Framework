<?php
namespace app\core;

class Application
{
    // Generally, objects like router, request, database, connection should be always a part of our application so we can access it from everywhere

    public Router $router;
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public function run()
    {
        $this->router->resolve();
    }
}