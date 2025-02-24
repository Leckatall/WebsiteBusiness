<?php

use Core\Database\Models\AccountModel;
use Core\Database\Models\CourseModel;
use Core\Database\Models\LessonModel;


$course_id = $_GET['course_id'];

$course_model = new CourseModel;
$course = $course_model->getById($course_id);
$course_users = $course_model->getUsersForCourse($course_id);


load_view('courses/users/index.view.php', [
    'heading' => '"'.htmlspecialchars($course['name']) . '" Participants',
    'course_users' => $course_users
]);
