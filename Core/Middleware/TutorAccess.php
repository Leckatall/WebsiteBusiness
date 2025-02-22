<?php

namespace Core\Middleware;

class TutorAccess implements Authoriser
{
    public static function authorise(): bool
    {
        return $_SESSION['privilege_level'] >= 2;
    }
}