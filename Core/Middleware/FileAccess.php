<?php

namespace Core\Middleware;

use Core\Models\FileModel;

class FileAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {
        //TODO
        return true;
    }
}