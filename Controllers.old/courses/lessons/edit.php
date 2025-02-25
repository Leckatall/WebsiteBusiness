<?php


use Core\Models\CourseModel;
use Core\Models\LessonModel;
use Core\Session;

$lesson = (new LessonModel)->getById($_GET['id']);
$courses = (new CourseModel)->getAll();

load_view('courses/lessons/update.view.php', [
    'heading' => 'Edit Lesson',
    'lesson' => $lesson,
    'courses' => $courses,
    'errors' => Session::get('lesson_errors')
]);

