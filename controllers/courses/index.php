<?php

use Core\Database;

$heading = "Courses";

$config = require base_path("config.php");
$db = new Database($config['database']);

$courses = $db->query("SELECT * FROM courses");
//dd($courses);

require base_path("views/courses/index.view.php");