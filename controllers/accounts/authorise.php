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

session_regenerate_id(true);
$_SESSION['user_id'] = $account['Id'];
$_SESSION['privilege_level'] = $account['PrivilegeLvl'];

redirect("/account?id={$_SESSION['user_id']}");


