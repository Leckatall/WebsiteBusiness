<?php

namespace Core\Middleware;

class TutorAccess implements Authoriser
{
    public static function authorise(): bool
    {
        return ($_SESSION['user']['privilege_level'] ?? 0) >= 2;
    }
}