<?php

use Core\App;
use Core\Database;

$db = App::run(Database::class);

$accounts = $db->query("SELECT * FROM Accounts")->fetchAll();

load_view('courses/index.view.php',
    ['heading' => 'Courses',
        'accounts' => $accounts]);





