<?php

use Core\Database\AccountManager;

$enrollable_students = AccountManager::getUnenrolledAccounts() ?? [];

if (!$enrollable_students) {
    $enrollable_students = [["Id" => 1, "Email"=> "blah"]];
}
load_view("portals/tutor/index.view.php", [
    'header' => 'Tutor Portal',
    'enrollable_students' => $enrollable_students]);





