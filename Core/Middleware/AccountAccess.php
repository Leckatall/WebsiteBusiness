<?php

namespace Core\Middleware;

// For accessing /account
// Route if:
// They're an admin
// It's their account
// they have not specified an account id (they will be served their account)
// Do not route users who have no account
use Core\Session;

class AccountAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {
        if (!$_SESSION['logged_in']) {
            return false;
        }
        if (Session::getRole() >= 3){
            return true;
        }
        if (!$id){
            return true;
        }
        return (Session::getId() == $id);
    }
}
