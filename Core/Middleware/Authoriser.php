<?php
namespace Core\Middleware;

interface Authoriser
{
    public function authorise(?int $id): bool;
}