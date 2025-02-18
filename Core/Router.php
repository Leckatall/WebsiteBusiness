<?php

namespace Core;

class Router{
    protected array $routes = [];

    public function addRoute($method, $uri, $controller){
        $this->routes[] = compact('method', 'uri', 'controller');
    }

    public function route($uri, $method='GET'){
        foreach($this->routes as $route){
            if($route['uri'] == $uri && $route['method'] == $method){
                return require base_path($route['controller']);
            }
        }
        $this->abort(404);
    }

    public function abort($status_code = 404){
        http_response_code($status_code);
        require base_path("views/{$status_code}.php");
    }
}
//function routeToController($uri, $routes){
//    if (array_key_exists($uri, $routes)){
//        require $routes[$uri];
//    } else {
//        abort();
//    }
//}




