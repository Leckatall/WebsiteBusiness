<?php

use Core\Models\CourseModel;
use Core\Session;
use Core\Validator;

$course_id = $_POST["course_id"];
$course_name = $_POST["name"];
$course_description = $_POST["description"] ?? "";
$errors = [];

if(!Validator::validateString($course_name)) {
    $errors["name"] = "name is required";
}
if(!empty($errors)) {
    // failed validation
    Session::flash('course_edit_errors', $errors);
    redirect("course/edit");
}

if (!(new CourseModel)->updateCourse($course_id, $course_name, $course_description)){
    Session::flash('course_edit_errors', ['name' => 'Course name must be unique']);
    redirect("course/edit");
}

redirect('/courses');
