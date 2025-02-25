<?php

use Core\Models\CourseModel;


// course_id > id to ensure no accidental deletions
(new CourseModel)->deleteById($_POST['course_id']);

redirect('/courses');




