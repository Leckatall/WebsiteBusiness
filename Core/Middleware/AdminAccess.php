<?php

namespace Core\Middleware;

class AdminAccess implements Authoriser
{
    public static function authorise(): bool
    {
        return $_SESSION['privilege_level'] >= 3;
    }
}