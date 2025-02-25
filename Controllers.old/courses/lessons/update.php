<?php

use Core\Models\CourseModel;
use Core\Session;
use Core\Validator;


$title = $_POST['title'];
$description = $_POST['description'];
$courseId = $_POST['courseId'];
$setDate = $_POST['set_date'] ?? date('Y-m-d');
$dueDate = $_POST['due_date'] ?? null;
$userId = $_SESSION['userId'];
$courseId = $_REQUEST['courseId'];

$errors = [];
// Validate Title
if (!Validator::validateString($title, 1, 64)) {
    $errors["title"] = "A title of less than 64 characters is required";
}
// Validate Description
if (!Validator::validateString($description, 1, 1000)) {
    $errors["description"] = "A description of less than 1000 characters is required";
}
// Ensure CourseId exists
if (!(new CourseModel)->getById($courseId)) {
    $errors["courseId"] = "CourseId does not exist";
}

if (!empty($errors)) {
    // failed validation
    Session::flash('lesson_errors', $errors);
    redirect('/lesson/edit');
}


