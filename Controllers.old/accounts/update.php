<?php

//TODO: Is this file necessary?

use Core\Database\Models\AccountModel;

function approve($account_id): void
{
    (new AccountModel)->approveAccount($account_id, $_SESSION['user']['id']);
}

// TODO: Give feedback to the user if they don't have the permissions
if ($_POST['action'] == 'approve') {
    approve($_POST['account_id']);
}

redirect('/accounts');

