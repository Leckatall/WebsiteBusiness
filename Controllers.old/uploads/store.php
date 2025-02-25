<?php

use Core\Models\FileModel;

$file = $_FILES['file'];
$customName = $_POST['custom_name'] ?? pathinfo($file['name'], PATHINFO_FILENAME);

$fileId = (new FileModel)->addFile($_SESSION['user']['id'], $file['name'], $customName);
if ($fileId > 0) {
    echo json_encode(["success" => true, "file" => [
        "id" => $pdo->lastInsertId(),
        "filename" => $file["name"],
        "custom_name" => $customName
    ]]);
} else {
    echo json_encode(["success" => false]);
}
