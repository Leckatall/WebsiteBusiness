<?php

namespace Core\Middleware;

use Core\Session;

class StudentAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {
        return Session::getRole() >= 1;
    }
}