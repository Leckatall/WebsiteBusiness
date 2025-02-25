<?php

use Core\Session;

load_view('accounts/login.view.php',
    ['heading' => "Login", 'error' => Session::get('login_error', [])]);




