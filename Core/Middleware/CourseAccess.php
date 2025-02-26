<?php

namespace Core\Middleware;

use Core\Models\CourseModel;
use Core\Session;

class CourseAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {
        if(Session::getRole() == 3){
            return true;
        }
        return (new CourseModel)->isUserInCourse(Session::getId(), $id);
    }
}