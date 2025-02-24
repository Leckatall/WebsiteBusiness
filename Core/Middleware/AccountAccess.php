<?php

namespace Core\Middleware;

class AccountAccess implements Authoriser
{
    public static function authorise(): bool
    {
        return ($_SESSION['user_id'] == $_REQUEST['id']) OR ($_SESSION['privilege_level'] >= 3);
    }
}
