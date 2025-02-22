<?php

use Core\App;
use Core\Database;


$db = App::run(Database::class);

$course = $db->query('SELECT * FROM Courses WHERE id = :id', [
    'id' => $_GET['id']
])->fetch();

$lessons = $db->query('SELECT * FROM Lessons WHERE CourseId = :course_id',
    ['course_id' => $_GET['id']])->fetchAll();

//$resources = $db->query('SELECT * FROM Resources WHERE CourseId = :id', ['id' => $_GET['id']]);
load_view('courses/show.view.php', [
    'heading' => htmlspecialchars($course["Name"]),
    'course' => $course,
    'lessons' => $lessons
]);
