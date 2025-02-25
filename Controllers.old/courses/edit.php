<?php

use Core\Database\Models\CourseModel;
use Core\Session;

$course = (new CourseModel)->getById($_GET['id']);

load_view('courses/edit.view.php', [
    'heading' => 'Edit Course',
    'course' => $course,
    'errors' => Session::get('course_edit_errors')
]);
