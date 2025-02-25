<?php

namespace Core\Controllers;

use Core\Database\Models\CourseModel;

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