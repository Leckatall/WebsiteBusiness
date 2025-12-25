<?php

use Core\Router;
use Core\Session;

require_once '../Core/bootstrap.php';

// Starts a session
session_start();

require base_path("Core/Router.php");

$router = Router::getInstance();
require base_path("/routes/index.php");

// setting the URI (the address bar contents after the domain) to a local variable
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
// Using a post method with a _method arg allows for custom request methods
$method = $_POST['_method'] ?? $_SERVER["REQUEST_METHOD"];

$router->route($uri, $method);


Session::clearFlash();

// TODONE: Authorise accounts interface
// TODONE: Students can access files in courses
// TODONE: Students can apply to enroll in a course and be approved by the tutor
// TODONE: Students can only view course pages of courses they are enrolled in
// TODONE: __init__ SQL Tables
// TODONE: Time restricted downloads for the students
// TODO: Maybe? Communicate they can't download it anymore better
// TODO: text files can be turned into quizzes
// TODO: Quizzes can have various question types
// TODO: Students score is saved after they complete a quiz
// TODO: Option to prevent retaking the quiz
// TODO: Scores are viewable by the tutor
// TODO: Show students their score
// TODO: Student has a progress bar indicating their knowledge of the course
// TODONE: Use of AJAX

