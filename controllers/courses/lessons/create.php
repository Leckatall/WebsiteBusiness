<?php

use Core\Database\Models\CourseModel;
use Core\Session;

$courses = (new CourseModel)->getAll();

load_view('courses/lessons/create.view.php', [
    'heading' => 'Add a Lesson',
    'courses' => $courses,
    'errors' => Session::get('lesson_create_errors')
]);