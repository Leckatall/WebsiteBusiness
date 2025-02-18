<?php

namespace Core;

class Router{
    protected $routes = [];

    public function addRoute($method, $uri, $controller){
        $this->routes[] = compact('method', 'uri', 'controller');
    }

    public function route($uri){
        foreach($this->routes as $route){
            if($route['uri'] == $uri){
                return require $route['controller'];
            }
        }
    }

    public function abort($status_code = 404){
        http_response_code($status_code);
        require "views/{$status_code}.php";
    }
}

//function routeToController($uri, $routes){
//    if (array_key_exists($uri, $routes)){
//        require $routes[$uri];
//    } else {
//        abort();
//    }
//}




