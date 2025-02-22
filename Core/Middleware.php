<?php

namespace Core;

//class Authenticators
//{
//    public static function AccountAccess(){
//        // Defines the conditions that allow an account page to be viewed
//        return function ($account){ return ($account['PrivilegeLvl'] >= 3) OR ($account['Id'] == $_GET['Id']); };
//    }
//}

interface Authoriser
{
    static public function authorise(): bool;
}
// Anyone can access
class PublicAccess implements Authoriser{
    public static function authorise(): bool
    {
        return true;
    }
}

// Must be logged in to view page
class LoggedInAccess implements Authoriser{
    public static function authorise(): bool
    {
        return isset($_SESSION["userId"]);
    }
}

// For accessing a specific account
// Must be an admin or accessing your own account
class AccountAccess implements Authoriser
{
    public static function authorise(): bool
    {
        return ($_SESSION['user_id'] == $_REQUEST['Id']) OR ($_SESSION['privilege_level'] >= 3);
    }
}
