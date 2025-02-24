<?php

namespace Core\Middleware;

// Must be logged in to view page
class LoggedInAccess implements Authoriser{
    public static function authorise(): bool
    {
        return isset($_SESSION['user']['id']);
    }
}