<?php

//$routes = [
//    "/" => "controllers/index.php",
//    "/aboutUs" => "controllers/aboutUs.php",
//    "/templates" => "controllers/templates.php",
//    "/login" => "controllers/login.php",
//];

use Core\Controllers\AccountController;
use Core\Controllers\CourseController;
use Core\Controllers\FileController;
use Core\Controllers\HomeController;
use Core\Controllers\LessonController;
use Core\Controllers\PortalController;
use Core\Controllers\UserController;

use Core\Middleware\AccountAccess;
use Core\Middleware\ChainedAccess;
use Core\Middleware\CourseAccess;
use Core\Middleware\FileAccess;
use Core\Middleware\LessonAccess;
use Core\Middleware\LoggedInAccess;
use Core\Middleware\StudentAccess;
use Core\Middleware\TutorAccess;


$router->addRoute('GET', '/', [HomeController::class, 'index']);
$router->addRoute('GET', '/aboutUs', [HomeController::class, 'about']);

$router->addRoute('GET', '/courses', [CourseController::class, 'index'], (new StudentAccess));
$router->addRoute('GET', '/api/courses', [CourseController::class, 'getIndex'], (new StudentAccess));
$router->addRoute('GET', '/courses/create', [CourseController::class, 'create'], (new TutorAccess));
$router->addRoute('GET', '/courses/{id}', [CourseController::class, 'show'], (new CourseAccess));
$router->addRoute('GET', '/courses/{id}/edit', [CourseController::class, 'edit'], (new TutorAccess));
$router->addRoute('GET', '/api/courses/{id}/users', [CourseController::class, 'getUsers'], (new ChainedAccess((new TutorAccess), (new CourseAccess))));

$router->addRoute('POST', '/courses', [CourseController::class, 'store'], (new TutorAccess));
$router->addRoute('DELETE', '/courses/{id}', [CourseController::class, 'destroy'], (new ChainedAccess((new TutorAccess), (new CourseAccess))));
$router->addRoute('PATCH', '/courses/{id}', [CourseController::class, 'update'], (new ChainedAccess((new TutorAccess), (new CourseAccess))));

$router->addRoute('GET', '/courses/{id}/users', [UserController::class, 'showUsers'], (new CourseAccess));
$router->addRoute('GET', '/me/courses', [UserController::class, 'showMyCourses'], (new StudentAccess));
$router->addRoute('GET', '/users/{id}/courses', [UserController::class, 'showUserCourses'], (new StudentAccess));
$router->addRoute('GET', '/api/users/{id}/courses', [UserController::class, 'getUserCourses'], (new StudentAccess));
$router->addRoute('POST', '/courses/{id}/users', [UserController::class, 'store'], (new StudentAccess));
$router->addRoute('POST', '/api/courses/{id}/users', [UserController::class, 'addUserToCourse'], (new StudentAccess));

$router->addRoute('PATCH', '/api/courses/{courseId}/users/{accountId}', [UserController::class, 'approveUserForCourse'], (new ChainedAccess((new TutorAccess), (new CourseAccess))));
$router->addRoute('DELETE', '/api/courses/{courseId}/users/{accountId}', [UserController::class, 'removeUserFromCourse'], (new ChainedAccess((new TutorAccess), (new CourseAccess))));

$router->addRoute('GET', '/api/courses/{id}/lessons', [LessonController::class, 'getLessonsForCourse'], (new CourseAccess));
$router->addRoute('GET', '/lessons/{id}', [LessonController::class, 'show'], (new LessonAccess));
$router->addRoute('GET', '/courses/{id}/lessons/create', [LessonController::class, 'create'], (new TutorAccess));
$router->addRoute('GET', '/lessons/create', [LessonController::class, 'create'], (new TutorAccess));
$router->addRoute('GET', '/lessons/{id}/edit', [LessonController::class, 'edit'], (new TutorAccess));
$router->addRoute('POST', '/lessons', [LessonController::class, 'store'], (new TutorAccess));
$router->addRoute('PUT', '/lessons/{id}', [LessonController::class, 'update'], (new ChainedAccess((new TutorAccess), (new LessonAccess))));

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

$router->addRoute('GET', '/api/uploads/{id}', [FileController::class, 'getFile'], (new FileAccess));
$router->addRoute('GET', '/api/uploads/lessons/{id}', [FileController::class, 'getFilesForLesson'], (new LessonAccess));
$router->addRoute('PATCH', '/api/uploads/{id}', [FileController::class, 'update'], (new FileAccess));
$router->addRoute('DELETE', '/api/uploads/{id}', [FileController::class, 'destroy'], (new FileAccess));
$router->addRoute('POST', '/api/uploads', [FileController::class, 'postFile'], (new FileAccess));



