<?php
namespace Core\Middleware;

interface Authoriser
{
    static public function authorise(?int $id): bool;
}