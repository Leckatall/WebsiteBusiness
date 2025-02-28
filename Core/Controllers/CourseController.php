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

    public function getIndex(): void
    {
        header('Content-Type: application/json');
        $filter = $_GET['filter'] ?? null;

        $courses = (new CourseModel)->getCoursesForUser(Session::getId());
        switch ($filter) {
            case 'My Courses':
                $courses = array_filter($courses, fn($course) => $course['applied'] and $course['approved']);
                break;
            case 'Pending':
                $courses = array_filter($courses, fn($course) => $course['applied'] and !$course['approved']);
                break;
            case 'Available':
                $courses = array_filter($courses, fn($course) => !$course['applied']);
                break;
        }
        echo json_encode(array_values($courses));
    }

    public function show(int $id): void
    {
        $course_model = new CourseModel;
        $course = $course_model->getById($id);
        $isParticipant = $course_model->isUserInCourse(Session::getId(), $id);

        //$resources = $db->query('SELECT * FROM Resources WHERE CourseId = :id', ['id' => $_GET['id']]);
        load_view('courses/show.view.php', [
            'heading' => $course["name"],
            'course' => $course,
            'isParticipant' => $isParticipant
        ]);
    }

    public function create(): void
    {
        load_view('courses/create.view.php', [
            'heading' => 'Add a Course',
            'errors' => Session::get('course_errors')
        ]);
    }

    public static function isValidCourse($course_name, $course_description, $update=false): bool
    {
        $errors = [];

        if (!Validator::validateString($course_name)) {
            $errors["name"] = "Course name is required";
        } else if (!$update AND (new CourseModel)->courseExists($course_name)) {
            $errors["name"] = "Course name is taken";
        }
        if (!Validator::validateString($course_description, 0, 100000)) {
            $errors["description"] = "Description is too long";
        }
        if (!empty($errors)) {
            // failed validation
            Session::flash('course_errors', $errors);
            return false;
        }
        return true;
    }

    public function store(): void
    {
        $course_name = htmlspecialchars($_POST["name"]);
        $course_description = htmlspecialchars($_POST["description"]) ?? "";

        if (!$this::isValidCourse($course_name, $course_description)) {
            // failed validation
            redirect("courses/create");
        }
        (new CourseModel)->addCourse(
            $course_name,
            $course_description,
            Session::getId());

        redirect('/courses');
    }

    public function edit(int $id): void
    {
        $course = (new CourseModel)->getById($id);

        load_view('courses/edit.view.php', [
            'heading' => 'Edit Course',
            'course' => $course,
            'errors' => Session::get('course_errors')
        ]);
    }

    public function update(int $id): void
    {
        $course_name = htmlspecialchars($_POST["name"]);
        $course_description = htmlspecialchars($_POST["description"]) ?? "";

        if (!$this::isValidCourse($course_name, $course_description, true)) {
            // failed validation
            redirect("/courses/$id/edit");
        }

        (new CourseModel)->updateCourse($id, $course_name, $course_description);

        redirect('/courses');
    }

    public function destroy(int $id): void
    {
        (new CourseModel)->deleteById($id);
    }

    public function getUsers(int $course_id)
    {
        header('Content-Type: application/json');
        $filter = $_GET['filter'] ?? null;

        $users =(new CourseModel)->getUsers($course_id);
        if ($filter == "applicants") {
            $users = array_values(array_filter($users, fn($user) => !$user['approved']));
        } else if ($filter == "participants") {
            $users = array_values(array_filter($users, fn($user) => $user['approved']));
        }
        echo json_encode(["success"=> true, "accounts" => $users]);
    }

    public function handleFormSubmission($course)
    {

    }
}