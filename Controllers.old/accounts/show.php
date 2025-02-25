<?php

use Core\Database\Models\AccountModel;


$account = (new AccountModel)->getById($_GET['id'] ?? $_SESSION['user']['id']);
const STATUSES = [
    0 => 'Pending',
    1 => 'Active'
];

load_view("accounts/show.view.php", [
    "heading" => "Your Account",
    "account" => $account
]);
