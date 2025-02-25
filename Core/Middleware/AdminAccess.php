<?php

namespace Core\Middleware;

class AdminAccess implements Authoriser
{
    public static function authorise(?int $id): bool
    {
        return ($_SESSION['user']['privilege_level'] ?? 0) >= 3;
    }
}