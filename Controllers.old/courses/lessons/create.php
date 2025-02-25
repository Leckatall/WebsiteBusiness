<?php

use Core\Database\Models\CourseModel;
use Core\Session;

$courses = (new CourseModel)->getAll();

load_view('courses/lessons/update.view.php', [
    'heading' => 'Add a Lesson',
    'courses' => $courses,
    'errors' => Session::get('lesson_errors')
]);
