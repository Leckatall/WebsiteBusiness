<?php


use Core\Models\AccountModel;

(new AccountModel)->deleteAccount($_POST['account_id'], $_SESSION['user']['privilege_level']);


redirect('/accounts');
