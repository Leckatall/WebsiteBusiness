<?php

namespace Core\Middleware;

class PublicAccess implements Authoriser{
    public static function authorise(?int $id): bool
    {
        return true;
    }
}