<?php

use Core\App;
use Core\Database\Database;

$db = App::run(Database::class);
$courses = $db->query("SELECT * FROM courses")->fetchAll();

load_view('courses/lessons/create.view.php', [
    'heading' => 'Add a Lesson',
    'courses' => $courses,
    'errors' => []
]);