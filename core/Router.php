<?php
namespace app\core;

class Router
{
    public Request $request;
    protected array $routes = [];

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        // Callback checks method and path. If it dont exist pass false to dont print errors to users
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            echo 'Not found';
            exit();
        }

        echo call_user_func($callback);
    }

}