<?php

use Core\App;
use Core\Database\Database;
use Core\Validator;

$db = App::run(Database::class);

$errors = [];

if(!Validator::validateString($_POST["name"])) {
    $errors["name"] = "Name is not valid";
}
if(!empty($errors)) {
    // failed validation
    load_view('courses/create.view.php', [
        'heading' => 'Add a Course',
        'errors' => $errors
    ]);
    dd($errors);
}

$db->query('INSERT INTO Courses(Name) VALUES(:Name)', ['Name' => $_POST["name"]]);

redirect('/courses');

