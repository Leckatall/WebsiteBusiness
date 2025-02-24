<?php

namespace Core\Middleware;

// For accessing /account
// Route if:
// They're an admin
// It's their account
// they have not specified an account id (they will be served their account)
// Do not route users who have no account
class AccountAccess implements Authoriser
{
    public static function authorise(): bool
    {
        if (!$_SESSION['logged_in']) {
            return false;
        }
        if ($_SESSION['user']['privilege_level'] >= 3){
            return true;
        }
        if (!$_REQUEST['id']){
            return true;
        }
        return ($_SESSION['user']['id'] == $_REQUEST['id']);
    }
}
