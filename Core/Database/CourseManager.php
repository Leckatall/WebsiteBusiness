<?php

namespace Core\Database;
use Core\App;


class CourseManager
{
    // TODO: Implement this
    public static function getCourses(){

    }
    public static function getCoursesByOwner($owner_id){
        $db = App::run(Database::class);
        $courses = $db->query("SELECT * FROM courses")->fetchAll();
    }
    public static function addCourse($course){

    }
    public static function removeCourse($course){

    }
    public static function updateCourse($course){

    }
    public static function getCourse($course){

    }
}