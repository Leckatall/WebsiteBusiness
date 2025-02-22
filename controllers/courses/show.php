<?php

use Core\App;
use Core\Database;


$db = App::run(Database::class);

$course = $db->query('SELECT * FROM Courses WHERE id = :id', [
    'id' => $_GET['id']
])->fetch();

load_view('courses/show.view.php', [
    'heading' => 'Course',
    'course' => $course
]);
