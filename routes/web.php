<?php

//$routes = [
//    "/" => "controllers/index.php",
//    "/aboutUs" => "controllers/aboutUs.php",
//    "/templates" => "controllers/templates.php",
//    "/login" => "controllers/login.php",
//];

use Core\Controllers\AccountController;
use Core\Controllers\CourseController;
use Core\Controllers\HomeController;
use Core\Controllers\PortalController;
use Core\Controllers\UserController;
use Core\Middleware\AccountAccess;
use Core\Middleware\LoggedInAccess;
use Core\Middleware\StudentAccess;
use Core\Middleware\TutorAccess;


$router->addRoute('GET', '/', [HomeController::class, 'index']);
$router->addRoute('GET', '/aboutUs', [HomeController::class, 'about']);

$router->addRoute('GET', '/courses', [CourseController::class, 'index'], (new StudentAccess));
$router->addRoute('GET', '/courses/create', [CourseController::class, 'create'], (new TutorAccess));
$router->addRoute('GET', '/courses/{id}', [CourseController::class, 'show'], (new StudentAccess));
$router->addRoute('GET', '/courses/{id}/edit', [CourseController::class, 'edit'], (new TutorAccess));

$router->addRoute('POST', '/courses', [CourseController::class, 'store'], (new TutorAccess));
$router->addRoute('DELETE', '/courses/{id}', [CourseController::class, 'destroy'], (new TutorAccess));
$router->addRoute('PATCH', '/courses/{id}', [CourseController::class, 'update'], (new TutorAccess));

$router->addRoute('GET', '/courses/{id}/users', [UserController::class, 'showUsers'], (new StudentAccess));
$router->addRoute('GET', '/me/courses', [UserController::class, 'showMyCourses'], (new StudentAccess));
$router->addRoute('GET', '/users/{id}/courses', [UserController::class, 'showUserCourses'], (new StudentAccess));
$router->addRoute('GET', '/api/users/{id}/courses', [UserController::class, 'getUserCourses'], (new StudentAccess));
$router->addRoute('POST', '/courses/{id}/users', [UserController::class, 'store'], (new StudentAccess));

$router->addRoute('GET', '/lessons/create', [LessonController::class, 'create'], (new TutorAccess));
$router->addRoute('GET', '/lessons/edit', [LessonController::class, 'edit'], (new TutorAccess));
$router->addRoute('POST', '/lessons', [LessonController::class, 'store'], (new TutorAccess));

//$router->addRoute('GET', '/uploads', 'controllers/uploads/index.php', (new StudentAccess));
//$router->addRoute('POST', '/uploads', 'controllers/uploads/upload.php', (new TutorAccess));
//$router->addRoute('PATCH', '/uploads', 'controllers/uploads/update.php', (new TutorAccess));
//$router->addRoute('DELETE', '/uploads', 'controllers/uploads/destroy.php', (new TutorAccess));
//
$router->addRoute('GET', '/register', [AccountController::class, 'register']);
$router->addRoute('GET', '/accounts', [AccountController::class, 'index'], (new TutorAccess));
$router->addRoute('GET', '/account', [AccountController::class, 'showMyAccount'], (new LoggedInAccess));
$router->addRoute('GET', '/api/accounts', [AccountController::class, 'getIndex'], (new TutorAccess));
$router->addRoute('GET', '/login', [AccountController::class, 'login_page']);
$router->addRoute('GET', '/accounts/{id}', [AccountController::class, 'show'], (new AccountAccess));
$router->addRoute('GET', '/logout', [AccountController::class, 'logout']);
$router->addRoute('POST', '/accounts', [AccountController::class, 'store']);
$router->addRoute('POST', '/login', [AccountController::class, 'login']);
$router->addRoute('DELETE', '/accounts/{id}', [AccountController::class, 'destroy'], (new TutorAccess));
$router->addRoute('PATCH', '/accounts/{id}', [AccountController::class, 'update'], (new TutorAccess));

$router->addRoute('GET', '/portal', [PortalController::class, 'index'], (new LoggedInAccess));

