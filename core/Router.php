<?php
namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        // Callback checks method and path. If it dont exist pass false to dont print errors to users
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }
        // If callback is string (called in application), return a view
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            // First iteration of array must be an object (not a string)
            $callback[0] = new $callback[0]();
        }
        return call_user_func($callback, $this->request);
    }

    public function renderView(string $view, $params = [])
    {
        foreach ($params as $key => $value) {
            // key will be variable now $name
            $$key = $value;
        }
        ob_start();
        include Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

}