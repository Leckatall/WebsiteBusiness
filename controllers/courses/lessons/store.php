<?php

use Core\App;
use Core\Database\Database;
use Core\Validator;

$db = App::run(Database::class);

$errors = [];

$title = $_POST['title'];
$description = $_POST['description'];
$courseId = $_POST['courseId'];
$setDate = $_POST['set_date'];
$dueDate = $_POST['due_date'] ?? null;
$userId = $_SESSION['user_id'];
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
if (count($db->query("SELECT Id FROM courses WHERE Id = :id",
        ['id' => $courseId])->fetchAll()) < 1) {
    $errors["courseId"] = "Course ID does not exist";
}

if (!empty($errors)) {
    // failed validation
    $courses = $db->query("SELECT * FROM Courses WHERE Id = :id",
        ['id' => $courseId])->fetchAll();
    load_view('courses/lessons/create.view.php', [
        'heading' => 'Add a Course',
        'courses' => $courses,
        'errors' => $errors
    ]);
    dd($errors);
}

$db->query('INSERT INTO LESSONS(CourseId, AuthorId, Title, Description, SetDate, DueDate) 
            VALUES(:courseId, :userId, :title, :description, :setDate, :dueDate)', [
    'courseId' => $courseId,
    'userId' => $_SESSION['user_id'],
    'title' => $title,
    'description' => $description,
    'setDate' => $setDate,
    'dueDate' => $dueDate
]);
$lessonId = $db->getLastInsertId();
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