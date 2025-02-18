<?php
//$routes = [
//    "/" => "controllers/index.php",
//    "/aboutUs" => "controllers/aboutUs.php",
//    "/templates" => "controllers/templates.php",
//    "/login" => "controllers/login.php",
//];

$router->addRoute('GET', '/', 'controllers/index.php');
$router->addRoute('GET', '/aboutUs', 'controllers/aboutUs.php');
$router->addRoute('GET', '/templates', 'controllers/templates.php');
$router->addRoute('GET', '/login', 'controllers/login.php');

$router->addRoute('GET', '/courses', 'controllers/courses/index.php');
$router->addRoute('GET', '/course', 'controllers/courses/show.php');

