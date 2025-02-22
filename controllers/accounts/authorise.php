<?php

use Core\AccountManager;


// If the login at// Logs the user in and adds ['user_id'] to the sessiontempt fails the reason is returned as a string
$login_error = AccountManager::login($_POST['email'], $_POST['password']);

if ($login_error) {
    // TODO: Use redirect function but also allow the passing of args?
    load_view('accounts/login.view.php',
        ['heading' => "Login", 'error' => $login_error]);
}


redirect("/account?id={$_SESSION['user_id']}");


