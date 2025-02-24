<?php

use Core\Database\Models\AccountModel;
use Core\Session;
use Core\Validator;


$email = $_POST['email'];
$password = $_POST['password'];
$privilegeLevel = $_POST['privilegeLevel'];

$errors = [];
$email_errs = Validator::email_errors($email);
if ($email_errs) {
    $errors['email'] = $email_errs;
}
$password_errs = Validator::password_errors($password);
if ($password_errs) {
    $errors['password'] = $password_errs;
}
if (!empty($errors)) {
    Session::flash('registration_errors', $errors);
    redirect('/register');
}

$account_model = new AccountModel;
if ($account_model->accountExists($email)) {
    // Email already in use
    Session::flash('registration_errors', ['email' => "Email already exists."]);
    redirect('/register');
}
// Should always work ig?
$accountId = $account_model->register($email, $password, $privilegeLevel);
if ($errors) {
    // failed validation
    Session::flash('registration_errors', $errors);
    redirect('/register');
}

$account_model->login($email, $password);

redirect("/account?id={$_SESSION['user']['id']}");
