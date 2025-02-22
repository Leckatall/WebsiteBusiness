<?php

use Core\App;
use Core\Database;


$db = App::run(Database::class);

// TODO: Add Auths
$db->query('DELETE FROM Courses WHERE id = :id', ['id' => $_POST['id']]);

header('location: /courses');

exit();




