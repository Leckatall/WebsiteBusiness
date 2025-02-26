<?php

namespace Core\Controllers;

use Core\Models\CourseModel;
use Core\Models\LessonModel;
use Core\Session;
use Core\Validator;

class LessonController extends BaseController
{
    public function index()
    {

    }

    public function show(int $id)
    {
        $courseId = (new LessonModel)->getCourseIdByLessonId($id);
        $course = (new CourseModel)->getById($courseId);

        load_view('courses/lessons/show.view.php', [
            'lessonId'=>$id,
            'course'=>$course,
        ]);
    }

    public function getLessonsForCourse(int $id)
    {
        header('Content-type: application/json');
        echo json_encode(["data"=>(new LessonModel)->getAllForCourse($id)]);
    }

    public function create(): void
    {
        $courses = (new CourseModel)->getCoursesWithUser(Session::getId());

        load_view('courses/lessons/update.view.php', [
            'heading' => 'Add a Lesson',
            'courses' => $courses,
            'errors' => Session::get('lesson_errors')
        ]);
    }

    public function isValidLesson($title, $description, $courseId): bool
    {
        $errors = [];
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
        if(!empty($errors)) {
            Session::flash('lesson_errors', $errors);
            return false;
        }
        return true;
    }

    public function store(): void
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $courseId = $_REQUEST['courseId'];
        $setDate = $_POST['set_date'] ?? date('Y-m-d');
        $dueDate = $_POST['due_date'] ?? null;

        if (!$this->isValidLesson($title, $description, $courseId)) {
            // failed validation
            redirect('/lessons/create');
        }

        $lesson_model = new LessonModel;
        $lessonId = $lesson_model->addLesson($courseId, $title, $description, $setDate, $dueDate);

        $uploadDir = base_path("uploads/lessons/lesson{$lessonId}/");
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true); // 0775 gives write permissions to owner and group
        }

        foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['files']['name'][$key]);
            $filePath = $uploadDir . uniqid() . '_' . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                // Save file details to the database
                $lesson_model->addFile($lessonId, $fileName, $filePath);
            } else {
                dd($filePath);
            }
        }

        redirect("/courses/{$courseId}");
    }

    public function edit(int $id): void
    {
        $lesson = (new LessonModel)->getById($id);
        $courses = (new CourseModel)->getCoursesWithUser(Session::getId());

        load_view('courses/lessons/update.view.php', [
            'heading' => 'Edit Lesson',
            'lesson' => $lesson,
            'courses' => $courses,
            'errors' => Session::get('lesson_errors')
        ]);
    }

    public function update(int $id): void
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $courseId = $_POST['courseId'];
        $setDate = $_POST['set_date'] ?? date('Y-m-d');
        $dueDate = $_POST['due_date'] ?? null;
        $userId = $_SESSION['userId'];
        $courseId = $_REQUEST['courseId'];

        if (!$this->isValidLesson($title, $description, $courseId)) {
            // failed validation
            redirect('/lesson/edit');
        }
        //TODO

    }

    public function destroy(int $id): void
    {

    }
}