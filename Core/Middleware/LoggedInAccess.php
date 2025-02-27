<?php

namespace Core\Middleware;

// Must be logged in to view page
class LoggedInAccess implements Authoriser{
    public function authorise(?int $id): bool
    {
        return isset($_SESSION['user']['id']);
    }
}