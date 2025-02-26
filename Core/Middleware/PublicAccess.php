<?php

namespace Core\Middleware;

class PublicAccess implements Authoriser{
    public function authorise(?int $id): bool
    {
        return true;
    }
}