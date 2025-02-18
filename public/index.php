<?php

use Core\Router;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . "Core/functions.php";

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    require base_path($class) . ".php";
});


require base_path("Core/Router.php");

require base_path("Core/bootstrap.php");
$router = new Router();
$routes = require base_path("routes.php");

// setting the URI (the address bar contents after the domain) to a local variable
$uri = parse_url($_SERVER["REQUEST_URI"])["path"];
$method = $_POST['_method'] ?? $_SERVER["REQUEST_METHOD"];

$router->route($uri);


//// connect to SQL DB
//require "Database.php";
//$db = new Database($config['database']);

