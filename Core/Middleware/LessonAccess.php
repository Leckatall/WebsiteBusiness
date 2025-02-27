<?php

namespace Core\Middleware;

use Core\Models\LessonModel;

class LessonAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {
        // id is lessonId so need to check if the user is in the parent course
        $courseId = (new LessonModel)->getById($id)['courseId'];
        return (new CourseAccess)->authorise($courseId);
    }

}