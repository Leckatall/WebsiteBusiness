<?php

namespace Core\Middleware;

class StudentAccess implements Authoriser
{
    public static function authorise(): bool
    {
        return $_SESSION['privilege_level'] >= 1;
    }
}