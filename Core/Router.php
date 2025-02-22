<?php

namespace Core;


use Core\Middleware\Authoriser;
use Core\Middleware\PublicAccess;

class Router{
    protected array $routes = [];

    public function addRoute($method, $uri, $controller, Authoriser $middleware=(new PublicAccess)){
        $this->routes[] = compact('method', 'uri', 'controller', 'middleware');
    }

    public function route($uri, $method='GET'){
        foreach($this->routes as $route){
            if($route['uri'] == $uri && $route['method'] == $method){
                // Middleware authorises whether the request will be allowed
                if (!$route['middleware']->authorise()) {
                    return $this->abort(401);
                }
                return require base_path($route['controller']);
            }
        }
        return $this->abort(404);
    }

    public function abort($status_code = 404){
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




