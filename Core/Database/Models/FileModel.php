<?php

namespace Core\Database\Models;

use Core\Database\Models\Model;

class FileModel extends Model
{
    protected string $table = 'user_files';

    public function __init_table(): void
    {
        $this->query('CREATE TABLE IF NOT EXISTS Files (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            accountId INT NOT NULL,
                            name VARCHAR(255) NOT NULL,
                            path VARCHAR(255) NOT NULL,
                            temp BOOLEAN DEFAULT TRUE,
                            FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE
                    );');
    }

    public function addFile(int $accountId, string $name, string $path): int
    {
        $this->query('INSERT INTO Files (accountId, name, path) 
                                       VALUES (:AccountId, :Name, :Path)', [
            'AccountId' => $accountId,
            'Name' => $name,
            'Path' => $path
        ]);
        return $this->lastInsertId();
    }

    public function uploadFile(int $userId, $file, string $customName): int
    {
        $uploadDir = base_path("uploads/");
        $filePath = $uploadDir . uniqid() . '_' . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Save file details to the database
            $fileId = $this->addFile($userId, $customName, $filePath);
            return $fileId;
        }
        return -1;
}