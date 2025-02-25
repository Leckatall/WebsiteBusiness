<?php

namespace Core\Middleware;

class StudentAccess implements Authoriser
{
    public static function authorise(?int $id): bool
    {
        return ($_SESSION['user']['privilege_level'] ?? 0) >= 1;
    }
}