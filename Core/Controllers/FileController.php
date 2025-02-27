<?php

namespace Core\Controllers;

use Core\Controllers\BaseController;
use Core\Models\FileModel;
use Core\Models\LessonModel;
use Core\Session;

class FileController extends BaseController
{
    public function getFile($id)
    {
        $file_model = new FileModel;
        $method = ($_GET['view'] ?? false) ? [$file_model, 'viewFile'] : [$file_model, 'downloadFile'];
        if ($method($id)) {
            exit;
        } else {
            echo json_encode(['error' => 'File not found']);
        }
    }

    public function getFilesForLesson($lessonId)
    {
        header('Content-type: application/json');
        $files = (new FileModel)->getLessonFiles($lessonId);
        if ($files) {
            foreach ($files as &$file) {
                $file['name'] = explode('_', basename($file['path'], 2))[1];
                unset($file['path']);
            }
            echo json_encode([
                "success" => true,
                "files" => $files]);
        } else {
            echo json_encode([
                "success" => false,
                "files" => []]);
        }
    }

    public function postFile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];

            // Get file details
            $fileName = basename($file['name']);
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];

            // Check if file uploaded without errors
            if ($fileError === 0) {
                // You can add extra validation (e.g., file size, file type)

                $fileTitle = $_POST["title"];

                $file_model = new FileModel;
                $fileId = $file_model->uploadFile(Session::getId(), $file, $fileTitle);
                // Move the uploaded file to the destination directory
                if ($fileId != -1) {
                    // Connect file to resource
                    $fileFor = $_POST["for"];
                    if ($fileFor == 'lessons') {
                        $fileForId = $_POST["forId"];
                        (new LessonModel)->addFile($fileForId, $fileId);
                    }
                    // Return a success response
                    echo json_encode(['success' => true, 'message' => 'File uploaded successfully!']);
                } else {
                    // Return an error response if file move fails
                    echo json_encode(['success' => false, 'message' => 'Failed to move the uploaded file.']);
                }
            } else {
                // Return an error if there was an issue with the upload
                echo json_encode(['success' => false, 'message' => 'Error during file upload.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
        }
    }

    public function update(int $id): void
    {
        header('Content-type: application/json');
        $action = $_REQUEST['action'] ?? 'rename';
        if ($action == 'rename'){
            $title = $_REQUEST['title'];
            $response = (new FileModel)->renameFile($id, $title)
                ? ['success' => true, 'message' => 'File renamed successfully!']
                : ['success' => false, 'message' => 'File not changed'];
            echo json_encode($response);
        }
    }

    public function destroy(int $id): void
    {
        header('Content-type: application/json');
        $response = (new FileModel)->deleteById($id)
                ? ['success' => true, 'message' => 'File renamed successfully!']
                : ['success' => false, 'message' => 'File not changed'];
        echo json_encode($response);
    }
}