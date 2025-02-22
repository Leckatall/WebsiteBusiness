<?php

use Core\App;
use Core\AccountManager;
use Core\Database;
use Core\Validator;

$db = App::run(Database::class);
$errors = [];

$email_errs = Validator::email_errors($_POST['email']);
if ($email_errs) {
    $errors['email'] = $email_errs;
}
$password_errs = Validator::password_errors($_POST['password']);
if ($password_errs) {
    $errors['password'] = $password_errs;
}
if(!empty($errors)) {
    // failed validation
    load_view('courses/create.view.php', [
        'heading' => 'Add a Course',
        'errors' => $errors
    ]);
    dd($errors);
}

AccountManager::register(["email" => $_POST['email'], "password" => $_POST['password']]);
redirect('account');
