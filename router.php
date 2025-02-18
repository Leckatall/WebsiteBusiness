<?php

// setting the URI (the address bar contents after the domain) to a local variable
$uri = parse_url($_SERVER["REQUEST_URI"])["path"];


$routes = [
    "/" => "controllers/index.php",
    "/aboutUs" => "controllers/aboutUs.php",
    "/templates" => "controllers/templates.php",
    "/login" => "controllers/login.php",
];



function routeToController($uri, $routes){
    if (array_key_exists($uri, $routes)){
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort($status_code = 404){
    http_response_code($status_code);
    require "views/{$status_code}.php";
}

routeToController($uri, $routes);


