<?php
//$routes = [
//    "/" => "controllers/index.php",
//    "/aboutUs" => "controllers/aboutUs.php",
//    "/templates" => "controllers/templates.php",
//    "/login" => "controllers/login.php",
//];

use Core\Middleware\AccountAccess;
use Core\Middleware\AdminAccess;
use Core\Middleware\LoggedInAccess;
use Core\Middleware\StudentAccess;
use Core\Middleware\TutorAccess;

//TODO: Add method routing
$router->addRoute('GET', '/', 'controllers/index.php');
$router->addRoute('GET', '/aboutUs', 'controllers/aboutUs.php');

$router->addRoute('GET', '/courses', 'controllers/courses/index.php', (new StudentAccess));
$router->addRoute('POST', '/courses', 'controllers/courses/store.php', (new TutorAccess));

$router->addRoute('GET', '/course', 'controllers/courses/show.php');
$router->addRoute('GET', '/course/users', 'controllers/courses/users/index.php', (new StudentAccess));
$router->addRoute('POST', '/course/users', 'controllers/courses/users/index.php', (new StudentAccess));

$router->addRoute('DELETE', '/course', 'controllers/courses/destroy.php', (new TutorAccess));
$router->addRoute('PATCH', '/course', 'controllers/courses/update.php', (new TutorAccess));
$router->addRoute('GET', '/courses/create', 'controllers/courses/create.php', (new TutorAccess));
$router->addRoute('GET', '/course/edit', 'controllers/courses/edit.php', (new TutorAccess));

$router->addRoute('GET', '/lessons/create', 'controllers/courses/lessons/create.php', (new TutorAccess));
$router->addRoute('GET', '/lessons/edit', 'controllers/courses/lessons/edit.php', (new TutorAccess));
$router->addRoute('POST', '/lessons', 'controllers/courses/lessons/store.php', (new TutorAccess));
$router->addRoute('POST', '/courses/resources', 'controllers/courses/resources/create.php', (new TutorAccess));

$router->addRoute('GET', '/uploads', 'controllers/uploads/index.php', (new StudentAccess));
$router->addRoute('POST', '/uploads', 'controllers/uploads/upload.php', (new TutorAccess));
$router->addRoute('PATCH', '/uploads', 'controllers/uploads/update.php', (new TutorAccess));
$router->addRoute('DELETE', '/uploads', 'controllers/uploads/destroy.php', (new TutorAccess));

$router->addRoute('GET', '/login', 'controllers/accounts/login.php');
$router->addRoute('GET', '/logout', 'controllers/accounts/logout.php');
$router->addRoute('POST', '/account', 'controllers/accounts/authorise.php');
$router->addRoute('GET', '/account', 'controllers/accounts/show.php', (new AccountAccess));
$router->addRoute('DELETE', '/account', 'controllers/accounts/destroy.php', (new TutorAccess));
$router->addRoute('PATCH', '/account', 'controllers/accounts/update.php', (new TutorAccess));

$router->addRoute('GET', '/student-portal', 'controllers/portals/student-portal.php', (new LoggedInAccess));
$router->addRoute('GET', '/tutor-portal', 'controllers/portals/tutor-portal.php', (new TutorAccess));
$router->addRoute('GET', '/admin-portal', 'controllers/portals/admin-portal.php', (new AdminAccess));

$router->addRoute('GET', '/register', 'controllers/accounts/register.php');
$router->addRoute('GET', '/accounts', 'controllers/accounts/index.php', (new TutorAccess));
$router->addRoute('POST', '/accounts', 'controllers/accounts/store.php');


