<?php
//$routes = [
//    "/" => "controllers/index.php",
//    "/aboutUs" => "controllers/aboutUs.php",
//    "/templates" => "controllers/templates.php",
//    "/login" => "controllers/login.php",
//];

use Core\Middleware\AccountAccess;
use Core\Middleware\AdminAccess;
use Core\Middleware\StudentAccess;
use Core\Middleware\TutorAccess;


$router->addRoute('GET', '/', 'controllers/index.php');
$router->addRoute('GET', '/aboutUs', 'controllers/aboutUs.php');
$router->addRoute('GET', '/templates', 'controllers/templates.php');

$router->addRoute('GET', '/courses', 'controllers/courses/index.php', (new StudentAccess));
$router->addRoute('POST', '/courses', 'controllers/courses/store.php', (new TutorAccess));

$router->addRoute('GET', '/course', 'controllers/courses/show.php');
$router->addRoute('DELETE', '/course', 'controllers/courses/destroy.php', (new TutorAccess));
$router->addRoute('GET', '/courses/create', 'controllers/courses/create.php', (new TutorAccess));

$router->addRoute('GET', '/courses/lessons/create', 'controllers/courses/lessons/create.php', (new TutorAccess));
$router->addRoute('POST', '/courses/lessons', 'controllers/courses/lessons/store.php', (new TutorAccess));
$router->addRoute('POST', '/courses/resources', 'controllers/courses/resources/create.php', (new TutorAccess));


$router->addRoute('GET', '/login', 'controllers/accounts/login.php');
$router->addRoute('GET', '/logout', 'controllers/accounts/logout.php');
$router->addRoute('POST', '/account', 'controllers/accounts/authorise.php');
$router->addRoute('GET', '/account', 'controllers/accounts/show.php', (new AccountAccess));

$router->addRoute('GET', '/register', 'controllers/accounts/register.php');
$router->addRoute('GET', '/accounts', 'controllers/accounts/index.php', (new AdminAccess));
$router->addRoute('POST', '/accounts', 'controllers/accounts/store.php');


