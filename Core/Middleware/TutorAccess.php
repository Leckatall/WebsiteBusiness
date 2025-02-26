<?php

namespace Core\Middleware;

use Core\Session;

class TutorAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {
        return Session::getRole() >= 2;
    }
}