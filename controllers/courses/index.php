<?php

use Core\Database\Models\CourseModel;


$courses = (new CourseModel)->getAll();

load_view('courses/index.view.php',
    ['heading' => 'Courses',
    'courses' => $courses]);
