<?php

use Core\Database\Models\AccountModel;
use Core\Session;


$email = $_POST['email'];
$password = $_POST['password'];

$account_model = new AccountModel;
if (!$account_model->accountExists($email)) {
    Session::flash('login_error', 'Email not found');
    redirect('/login');
}

$account = $account_model->login($email, $password);
if (!$account) {
    Session::flash('login_error', 'Incorrect password');
    redirect('/login');
}

redirect("/account?id={$account['id']}");


