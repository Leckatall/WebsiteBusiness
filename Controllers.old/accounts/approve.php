<?php
//TODO: Is this file necessary?

use Core\Database\Models\AccountModel;

(new AccountModel)->approveAccount($_GET['id'], $_SESSION['user']['id']);

redirect('/accounts');
