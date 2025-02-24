<?php

use Core\Session;

load_view('accounts/register.view.php',
    ['heading' => "Register", 'errors' => Session::get('registration_errors')]);
