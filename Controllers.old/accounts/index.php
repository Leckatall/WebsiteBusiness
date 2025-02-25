<?php

use Core\Models\AccountModel;

$accounts = (new AccountModel)->getAll();
load_view('accounts/index.view.php',
    ['heading' => 'Courses',
        'accounts' => $accounts]);





