<?php

use Core\App;
use Core\Database\Database;

$db = App::run(Database::class);

$account = $db->query('SELECT * FROM Accounts WHERE id = :id', [
    'id' => $_GET['id']
])->fetch();
const STATUSES = [
    0 => 'Pending',
    1 => 'Active'
];

load_view("accounts/show.view.php", [
    "heading" => "Your Account",
    "account" => $account,
    "status" => STATUSES[$account['Status']]]);
