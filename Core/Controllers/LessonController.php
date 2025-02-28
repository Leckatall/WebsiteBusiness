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
        $user_registered = (new LessonModel)->isUserInLesson($lesson['id'], Session::getId());
        $lesson_user = (new LessonModel)->getLessonUser($lesson['id'], Session::getId()) ?? null;
        $course = (new CourseModel)->getById($lesson['courseId']);

        load_view('courses/lessons/show.view.php', [
            'heading' => $course['name'],
            'lesson' => $lesson,
            'user_registered' => $user_registered,
            'lesson_user' => $lesson_user,
            'course' => $course,
        ]);
    }

    public function getLessonsForCourse(int $id)
    {
        header('Content-type: application/json');
        $lessons = (new LessonModel)->getResultsForCourse($id, Session::getId());
        // If student accessing lessons only let them see the ones with set_date after today
        if (Session::getRole() == 1) {
            $lessons = array_values(array_filter($lessons, fn($lesson) => $lesson['set_date'] <= date('Y-m-d')));
        }
        echo json_encode(["success" => true, "lessons" => $lessons]);
    }

    public function create(int $courseId): void
    {
        $courses = (new CourseModel)->getCoursesWithUser(Session::getId());

        load_view('courses/lessons/update.view.php', [
            'heading' => 'Add a Lesson',
            'courses' => $courses,
            'defaultCourseId' => $courseId,
            'errors' => Session::get('lesson_errors'),
            'defaults' => Session::get('lesson_defaults')
        ]);
    }

    public function isValidLesson($title, $description, $courseId, $set_date, $due_date = null): bool
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
        if (!Validator::validateDate($set_date)) {
            $errors["set_date"] = "Set date cannot be in the past";
        }
        // Validate Due Date
        if ($due_date !== null && !Validator::validateDate($due_date, $set_date)) {
            $errors["due_date"] = "Due date must be after set date";
        }
        //TODO: Validate "no lessons with the same name"
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
        $set_date = $_POST['set_date'] ?? date('Y-m-d');
        $due_date = $_POST['due_date'] ?? null;
        $student_action = $_POST['student_action'] ?? 0;
        $courseId = $_REQUEST['courseId'];

        if (!$this->isValidLesson($title, $description, $courseId, $set_date, $due_date)) {
            // failed validation
            Session::flash('lesson_defaults', compact('title', 'description', 'courseId', 'set_date', 'due_date', 'student_action'));
            redirect("/courses/$courseId/lessons/create");
        }

        $lesson_model = new LessonModel;
        $lessonId = $lesson_model->addLesson($courseId, $title, $description, $set_date, $due_date);
        redirect("/courses/$courseId");
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
        $set_date = $_POST['set_date'] ?? date('Y-m-d');
        $due_date = $_POST['due_date'] ?? null;
        $student_action = $_POST['student_action'] ?? 0;
        $courseId = $_REQUEST['courseId'];

        if (!$this->isValidLesson($title, $description, $courseId, $set_date, $due_date)) {
            // failed validation
            Session::flash('lesson_defaults', compact('title', 'description', 'courseId', 'set_date', 'due_date', 'student_action'));
            redirect("/lessons/$id/edit");
        }

        if ($_POST['action'] == 'update') {
            (new LessonModel)->updateLesson($id, $courseId, $title, $description, $set_date, $due_date, $student_action);
        }
        redirect("/lessons/{$id}");
    }

    public function destroy(int $id): void
    {
        header("Content-type: application/json");
        echo json_encode(["success" => (new LessonModel)->deleteLesson($id)]);
    }
}