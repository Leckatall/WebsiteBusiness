<?php

namespace Core\Middleware;

use Core\Models\FileModel;
use Core\Session;

class FileAccess implements Authoriser
{
    public function authorise(?int $id): bool
    {

        if(Session::getRole() == 3){
            // Admins can access all files
            return true;
        }
        $file_model = (new FileModel);
        $file = $file_model->getById($id);
        if($file['accountId'] == Session::getId()){
            // Can access files you uploaded
            return true;
        }
        $file_lesson = $file_model->getFileLesson($id);
        if($file_lesson){
            if((new LessonAccess)->authorise($file_lesson)){
                if(Session::getRole() == 1){
                    return !$file_model->isFileExpired($id);
                }
                return true;
            }
        }
        return false;
    }
}