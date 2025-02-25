<?php

namespace Core\Controllers;

use Core\Models\CourseModel;
use Core\Session;

// Controls user(account+data) pages
class UserController extends BaseController
{
    public function index()
    {

    }

    public function showUsers(int $course_id)
    {
        $course_model = new CourseModel;
        $course = $course_model->getById($course_id);
        $course_users = $course_model->getUsersForCourse($course_id);


        load_view('courses/users/index.view.php', [
            'heading' => '"' . htmlspecialchars($course['name']) . '" Participants',
            'course_users' => $course_users
        ]);
    }

    public function getUserCourses(int $userId)
    {
        header('Content-Type: application/json');
        $courses = (new CourseModel)->getCoursesForUser($userId);
        if (!$courses) {
            echo json_encode(["data"=>[], "error" => "No courses found"]);
        } else {
            echo json_encode(["data" => $courses]);
        }
    }

    public function getMyCourses()
    {
        $this->getUserCourses(Session::getId());
    }

    public function showUserCourses(int $userId): void
    {
        load_view('courses/users/user_courses.view.php', [
            'heading' => 'Account Courses',
            'user_id' => $userId
        ]);
    }

    public function showMyCourses()
    {
        $this->showUserCourses(Session::getId());
    }

    public function addUserToCourse(int $course_id)
    {
        $userId = $_SESSION['user']['id'];
        $courseId = $_POST['course_id'];
        (new CourseModel)->addUserToCourse($userId, $courseId);

        redirect('/courses');
    }


    public function store(): void
    {

    }
}