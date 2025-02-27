<?php

namespace Core\Controllers;

use Core\Models\CourseModel;
use Core\Models\LessonModel;
use Core\Session;

// Controls user(account+data) pages
class UserController extends BaseController
{
    public function index()
    {

    }

    public function getUsersForCourse($courseId)
    {
        header('Content-Type: application/json');
        $users = (new CourseModel)->getUsers($courseId);
        if (!$users) {
            echo json_encode(["success" => false, "data" => [], "error" => "No courses found"]);
        } else {
            echo json_encode(["success" => true, "users" => $users]);
        }
    }

    public function showUsers(int $course_id)
    {
        $course_model = new CourseModel;
        $course = $course_model->getById($course_id);
        $course_users = $course_model->getUsers($course_id);


        load_view('courses/users/index.view.php', [
            'heading' => '"' . htmlspecialchars($course['name']) . '" Participants',
            'course_users' => $course_users
        ]);
    }

    public function getUserCourses(int $userId)
    {
        header('Content-Type: application/json');
        $courses = (new CourseModel)->getCoursesWithUser($userId);
        if (!$courses) {
            echo json_encode(["data" => [], "error" => "No courses found"]);
        } else {
            echo json_encode(["data" => $courses]);
        }
    }

    public function getMyCourses()
    {
        $this->getCourses(Session::getId());
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

    public function addUserToCourse(int $courseId)
    {
        (new CourseModel)->addUserToCourse(Session::getId(), $courseId);

    }

    public function approveUserForCourse(int $courseId, int $userId)
    {
        header('Content-Type: application/json');
        echo json_encode(["success" => (new CourseModel)->approveUserToCourse($courseId, $userId)]);
    }

    public function removeUserFromCourse(int $courseId, int $userId)
    {
        header('Content-Type: application/json');
        echo json_encode(["success" => (new CourseModel)->removeUserFromCourse($courseId, $userId)]);
    }

    public function addUserToLesson(int $lessonId)
    {
        if ((new LessonModel)->registerToLesson($lessonId, Session::getId())) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }
    }

    public function getUsersForLesson($lessonId)
    {
        header('Content-Type: application/json');

        // TODO: Implement selecting the type of user you want to get
        $users = (new LessonModel)->getStudentsForLesson($lessonId);
        if ($users) {
            echo json_encode(["success" => true, "users" => $users]);
        } else {
            echo json_encode(["success" => false, "users" => [], "error" => "No users found for this lesson"]);
        }
    }

    public function updateUserLessonScore($lessonId, $userId)
    {
        header('Content-Type: application/json');
        $score = $_REQUEST['score'];
        echo json_encode(["success" => (new LessonModel)->updateUserScore($lessonId, $userId, $score)]);
    }


    public function store(): void
    {

    }
}