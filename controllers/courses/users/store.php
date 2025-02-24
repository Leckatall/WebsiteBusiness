<?php

use Core\Database\Models\CourseModel;

$userId = $_SESSION['user']['id'];
$courseId = $_POST['course_id'];
(new CourseModel)->addUserToCourse($userId, $courseId);

redirect('/courses');
