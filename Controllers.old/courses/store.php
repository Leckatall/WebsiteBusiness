<?php

use Core\Models\CourseModel;
use Core\Session;
use Core\Validator;

$course_name = $_POST["name"];
$course_description = $_POST["description"] ?? "";
$errors = [];

if(!Validator::validateString($course_name)) {
    $errors["name"] = "name is required";
}
if(!empty($errors)) {
    // failed validation
    Session::flash('course_creation_errors', $errors);
    redirect("courses/create");
}
if (!(new CourseModel)->addCourse($course_name, $course_description, $_SESSION['user']['id'])) {
    Session::flash('course_creation_errors', ['name' => 'Course name must be unique']);
    redirect("course/create");
}

redirect('/courses');

