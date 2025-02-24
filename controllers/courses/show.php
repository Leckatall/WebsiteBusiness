<?php


use Core\Database\Models\CourseModel;
use Core\Database\Models\LessonModel;


$course_id = $_GET['id'];

$course_model = new CourseModel;
$course = $course_model->getById($course_id);
$isParticipant = $course_model->isUserInCourse($_SESSION['user']['id'], $course_id);

$lessons = (new LessonModel)->getAllForCourse($course_id);

//$resources = $db->query('SELECT * FROM Resources WHERE CourseId = :id', ['id' => $_GET['id']]);
load_view('courses/show.view.php', [
    'heading' => htmlspecialchars($course["name"]),
    'course' => $course,
    'lessons' => $lessons,
    'isParticipant' => $isParticipant
]);
