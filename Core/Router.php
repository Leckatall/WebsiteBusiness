<?php

namespace Core;


use Core\Middleware\Authoriser;
use Core\Middleware\PublicAccess;

class Router
{
    protected array $routes = [];
    private static $instance;

    private function __construct()
    {

    }

    public static function getInstance(): Router
    {
        if (!isset(self::$instance)) {
            self::$instance = new Router();
        }
        return self::$instance;
    }


    public function addRoute($method, $uri, $controllerMethod, Authoriser $middleware = (new PublicAccess))
    {
        $this->routes[] = compact('method', 'uri', 'controllerMethod', 'middleware');
    }

    public function route($uri, $method = 'GET')
    {
        foreach ($this->routes as $route) {
            if ($route['method'] == $method) {
                $pattern = $route['uri'];
                // Convert the route pattern to a regex
                $pattern = preg_replace('/{(\w+)}/', '(\w+)', $pattern);
                $pattern = '#^' . $pattern . '/?$#';

                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches); // Remove the URL
                    // Middleware authorises whether the request will be allowed
                    if ($route['middleware']->authorise($matches[0] ?? null)) {
                        // Instantiate the controller
                        $controller = new $route['controllerMethod'][0];
                        $controller_method = $route['controllerMethod'][1];

                        // Pass the captured values to the controller method
                        return call_user_func_array([$controller, $controller_method], $matches);
                    }
                    return $this->abort(401);
                }
            }
        }
        //dd($uri);
        return $this->abort(404);
    }

    public function abort($status_code = 404): bool
    {
        http_response_code($status_code);
        require base_path("views/{$status_code}.php");
        return false;
    }
}
//function routeToController($uri, $routes){
//    if (array_key_exists($uri, $routes)){
//        require $routes[$uri];
//    } else {
//        abort();
//    }
//}




