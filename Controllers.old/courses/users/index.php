<?php

use Core\Models\CourseModel;


$course_id = $_GET['course_id'];

$course_model = new CourseModel;
$course = $course_model->getById($course_id);
$course_users = $course_model->getUsers($course_id);


load_view('courses/users/index.view.php', [
    'heading' => '"'.htmlspecialchars($course['name']) . '" Participants',
    'course_users' => $course_users
]);
