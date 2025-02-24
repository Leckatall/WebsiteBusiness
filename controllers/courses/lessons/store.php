<?php

use Core\App;
use Core\Database\Database;
use Core\Database\Models\CourseModel;
use Core\Database\Models\LessonModel;
use Core\Session;
use Core\Validator;

$db = App::run(Database::class);

$errors = [];

$title = $_POST['title'];
$description = $_POST['description'];
$courseId = $_POST['courseId'];
$setDate = $_POST['set_date'];
$dueDate = $_POST['due_date'] ?? null;
$userId = $_SESSION['userId'];
$courseId = $_REQUEST['courseId'];

// Validate Title
if (!Validator::validateString($title, 1, 64)) {
    $errors["title"] = "A title of less than 64 characters is required";
}
// Validate Description
if (!Validator::validateString($description, 1, 1000)) {
    $errors["description"] = "A description of less than 1000 characters is required";
}
// Ensure CourseId exists
if (!(new CourseModel)->getById($courseId)) {
    $errors["courseId"] = "CourseId does not exist";
}

if (!empty($errors)) {
    // failed validation
    Session::flash('lesson_create_errors', $errors);
    redirect('/lessons/create');
}

// Before implementing models. This junk was littered about my code
//$db->query('INSERT INTO LESSONS(CourseId, AuthorId, Title, Description, SetDate, DueDate)
//            VALUES(:courseId, :userId, :title, :description, :setDate, :dueDate)', [
//    'courseId' => $courseId,
//    'userId' => $_SESSION['user']['id'],
//    'title' => $title,
//    'description' => $description,
//    'setDate' => $setDate,
//    'dueDate' => $dueDate
//]);

$lessonId = (new LessonModel)->addLesson($courseId, $title, $description, $setDate, $dueDate);

$uploadDir = base_path("public/uploads/lessons/lesson{$lessonId}/");
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true); // 0775 gives write permissions to owner and group
}

foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
    $fileName = basename($_FILES['files']['name'][$key]);
    $filePath = $uploadDir . uniqid() . '_' . $fileName;

    if (move_uploaded_file($tmpName, $filePath)) {
        // Save file details to the database
        $stmt = $db->query("INSERT INTO Lesson_files (LessonId, FilePath) 
                            VALUES (:lesson_id, :file_path)", [
            ':lesson_id' => $lessonId,
            ':file_path' => $filePath
        ]);
    }else{
        dd($filePath);
    }
}

redirect("/course?id={$courseId}");