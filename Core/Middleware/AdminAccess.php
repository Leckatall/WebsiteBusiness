<?php

namespace Core\Middleware;

use Core\Session;

class AdminAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {
        return Session::getRole() >= 3;
    }
}