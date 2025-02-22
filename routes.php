<?php
//$routes = [
//    "/" => "controllers/index.php",
//    "/aboutUs" => "controllers/aboutUs.php",
//    "/templates" => "controllers/templates.php",
//    "/login" => "controllers/login.php",
//];

use Core\AccountAccess;

CONST PRIVILEGE_LVLS = [
    "ALL" => 0,
    "STUDENT" => 1,
    "TUTOR" => 2,
    "ADMIN" => 3
];

$router->addRoute('GET', '/', 'controllers/index.php');
$router->addRoute('GET', '/aboutUs', 'controllers/aboutUs.php');
$router->addRoute('GET', '/templates', 'controllers/templates.php');

$router->addRoute('GET', '/courses', 'controllers/courses/index.php');
$router->addRoute('GET', '/course', 'controllers/courses/show.php');
$router->addRoute('DELETE', '/course', 'controllers/courses/destroy.php', PRIVILEGE_LVLS["TUTOR"]);

$router->addRoute('GET', '/courses/create', 'controllers/courses/create.php', PRIVILEGE_LVLS["TUTOR"]);
$router->addRoute('POST', '/courses', 'controllers/courses/store.php', PRIVILEGE_LVLS["TUTOR"]);

$router->addRoute('GET', '/login', 'controllers/accounts/login.php');
$router->addRoute('POST', '/account', 'controllers/accounts/authorise.php');
$router->addRoute('GET', '/account', 'controllers/accounts/show.php', (new AccountAccess));

$router->addRoute('GET', '/register', 'controllers/accounts/register.php');
$router->addRoute('POST', '/accounts', 'controllers/accounts/store.php');


