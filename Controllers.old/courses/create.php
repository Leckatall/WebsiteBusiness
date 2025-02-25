<?php

use Core\Session;

load_view('courses/create.view.php', [
'heading' => 'Add a Course',
    'errors' => Session::get('course_creation_errors')
]);
