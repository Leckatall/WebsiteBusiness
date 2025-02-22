<?php

use Core\App;
use Core\Database\Database;


$db = App::run(Database::class);

$account = $db->query('SELECT * FROM Accounts WHERE id = :id', [
    'id' => $_SESSION['id']
])->fetch();

if ($account['Status'] == 0){
    redirect('/pending');
}

