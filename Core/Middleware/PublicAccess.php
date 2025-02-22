<?php

namespace Core\Middleware;

class PublicAccess implements Authoriser{
    public static function authorise(): bool
    {
        return true;
    }
}