<?php

namespace Core\Controllers;


use Core\Models\CourseModel;
use Core\Models\LessonModel;
use Core\Session;
use Core\Validator;

class CourseController extends BaseController
{
    public function index(): void
    {
        $courses = (new CourseModel)->getAll();

        load_view('courses/index.view.php', [
            'heading' => 'Courses',
            'courses' => $courses]);
    }

    public function show(int $id): void
    {
        $course_model = new CourseModel;
        $course = $course_model->getById($id);
        $isParticipant = $course_model->isUserInCourse($_SESSION['user']['id'], $id);

        $lessons = (new LessonModel)->getAllForCourse($id);

        //$resources = $db->query('SELECT * FROM Resources WHERE CourseId = :id', ['id' => $_GET['id']]);
        load_view('courses/show.view.php', [
            'heading' => htmlspecialchars($course["name"]),
            'course' => $course,
            'lessons' => $lessons,
            'isParticipant' => $isParticipant
        ]);
    }

    public function create(): void
    {
        load_view('courses/create.view.php', [
            'heading' => 'Add a Course',
            'errors' => Session::get('course_creation_errors')
        ]);
    }

    public function store(): void
    {
        $course_name = $_POST["name"];
        $course_description = $_POST["description"] ?? "";
        $errors = [];

        if (!Validator::validateString($course_name)) {
            $errors["name"] = "name is required";
        }
        if (!empty($errors)) {
            // failed validation
            Session::flash('course_creation_errors', $errors);
            redirect("courses/create");
        }
        if (!(new CourseModel)->addCourse($course_name, $course_description, $_SESSION['user']['id'])) {
            Session::flash('course_creation_errors', ['name' => 'Course name must be unique']);
            redirect("course/create");
        }

        redirect('/courses');
    }

    public function edit(int $id): void
    {
        $course = (new CourseModel)->getById($id);

        load_view('courses/edit.view.php', [
            'heading' => 'Edit Course',
            'course' => $course,
            'errors' => Session::get('course_edit_errors')
        ]);
    }

    public function update(int $id): void
    {
        $course_id = $_POST["course_id"];
        $course_name = $_POST["name"];
        $course_description = $_POST["description"] ?? "";
        $errors = [];

        if (!Validator::validateString($course_name)) {
            $errors["name"] = "name is required";
        }
        if (!empty($errors)) {
            // failed validation
            Session::flash('course_edit_errors', $errors);
            redirect("course/edit");
        }

        if (!(new CourseModel)->updateCourse($course_id, $course_name, $course_description)) {
            Session::flash('course_edit_errors', ['name' => 'Course name must be unique']);
            redirect("course/edit");
        }

        redirect('/courses');
    }

    public function destroy(int $id): void
    {
        (new CourseModel)->deleteById($id);
    }

    public function handleFormSubmission($course)
    {

    }
}