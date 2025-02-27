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
        $lesson = (new LessonModel)->getById($id);
        $course = (new CourseModel)->getById($lesson['courseId']);

        load_view('courses/lessons/show.view.php', [
            'heading' => $course['name'],
            'lesson' => $lesson,
            'course' => $course,
        ]);
    }

    public function getLessonsForCourse(int $id)
    {
        header('Content-type: application/json');
        echo json_encode(["data" => (new LessonModel)->getAllForCourse($id)]);
    }

    public function create(int $courseId): void
    {
        $courses = (new CourseModel)->getCoursesWithUser(Session::getId());

        load_view('courses/lessons/update.view.php', [
            'heading' => 'Add a Lesson',
            'courses' => $courses,
            'defaultCourseId' => $courseId,
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
        if (!empty($errors)) {
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
        $setDate = $_POST['set_date'] ?? date('Y-m-d');
        $dueDate = $_POST['due_date'] ?? null;
        $studentAction = $_POST['student_action'] ?? 0;
        $courseId = $_REQUEST['courseId'];

        if (!$this->isValidLesson($title, $description, $courseId)) {
            // failed validation
            redirect('/lesson/edit');
        }

        if($_POST['action'] == 'update') {
            (new LessonModel)->updateLesson($id, $courseId, $title, $description, $setDate, $dueDate, $studentAction);
        }
        redirect("/lessons/{$id}");
    }

    public function destroy(int $id): void
    {

    }
}