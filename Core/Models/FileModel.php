<?php

namespace Core\Models;

class FileModel extends Model
{
    protected string $table = 'Files';

    public function __init_table(): void
    {
        $this->query('CREATE TABLE IF NOT EXISTS Files (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            accountId INT NOT NULL,
                            title VARCHAR(255) NOT NULL,
                            path VARCHAR(255) NOT NULL,
                            temp BOOLEAN DEFAULT FALSE,
                            FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE
                    );');
    }

    public function addFile(int $accountId, string $title, string $path): int
    {
        $this->query('INSERT INTO Files (accountId, title, path) 
                                       VALUES (:AccountId, :Title, :Path)', [
            'AccountId' => $accountId,
            'Title' => $title,
            'Path' => $path
        ]);
        return $this->lastInsertId();
    }

    public function getTutorLessonFiles($lessonId)
    {
        return $this->query('SELECT f.id AS id,
                               f.title AS title,
                               f.path AS path
                        FROM Files f
                        INNER JOIN Lesson_files lf ON f.id = lf.fileId
                        INNER JOIN accounts a ON a.id = f.accountId
                        WHERE lf.lessonId = :LessonId
                        AND a.privilege_level = 2', ['LessonId' => $lessonId])->fetchAll();
    }

    public function getAllStudentLessonFiles($lessonId)
    {
        return $this->query('SELECT f.id AS id,
                               f.title AS title,
                               f.path AS path
                        FROM Files f
                        INNER JOIN Lesson_files lf ON f.id = lf.fileId
                        INNER JOIN accounts a ON a.id = f.accountId
                        WHERE lf.lessonId = :LessonId
                        AND a.privilege_level = 1', ['LessonId' => $lessonId])->fetchAll();
    }

    public function getStudentLessonFiles($lessonId, $accountId)
    {
        return $this->query('SELECT f.id AS id,
                               f.title AS title,
                               f.path AS path
                        FROM Files f
                        INNER JOIN Lesson_files lf ON f.id = lf.fileId
                        INNER JOIN accounts a ON a.id = f.accountId
                        WHERE lf.lessonId = :LessonId
                        AND a.id = :AccountId
                        AND a.privilege_level = 1', [
            'LessonId' => $lessonId,
            'AccountId' => $accountId])->fetchAll();
    }

    public function getLessonFiles($lessonId)
    {
        return $this->query('SELECT f.id AS id,
                                   f.title AS title,
                                   f.path AS path
                            FROM Files f
                            INNER JOIN Lesson_files lf ON f.id = lf.fileId
                            WHERE lf.lessonId = :LessonId', ['LessonId' => $lessonId])->fetchAll();
    }

    public function uploadFile(int $userId, $file, string $customName): int
    {
        $uploadDir = base_path("uploads/");
        $filePath = $uploadDir . uniqid() . '_' . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Save file details to the database
            $fileId = $this->addFile($userId, htmlspecialchars($customName), $filePath);
            return $fileId;
        }
        return -1;
    }

    public function getFile(int $fileId)
    {
        $file = $this->getById($fileId);
        if ($file) {
            if (file_exists($file['path'])) {
                return $file;
            }
        }
        return null;
    }

    public function getFileLesson(int $fileId)
    {
        return $this->query('SELECT lf.lessonId
                            FROM Lesson_files lf
                            WHERE lf.fileId = :FileId', ['FileId' => $fileId])->fetchColumn();
    }

    public function isFileExpired(int $fileId): bool
    {
        return (bool)$this->query('SELECT 
                            CASE 
                                WHEN lf.fileId IS NULL THEN FALSE
                                WHEN (l.due_date IS NULL OR l.due_date = "0000-00-00") THEN FALSE
                                WHEN l.due_date >= CURRENT_DATE THEN FALSE
                                ELSE TRUE
                            END AS is_expired
                            FROM Files f
                            LEFT JOIN Lesson_files lf ON f.id = lf.fileId
                            LEFT JOIN Lessons l ON lf.lessonId = l.id
                            WHERE f.id = :FileId
                            LIMIT 1;', [
            'FileId' => $fileId
        ])->fetchColumn();
    }

    public function viewFile(int $fileId): bool
    {
        $file = $this->getFile($fileId);
        if ($file) {
            $mime = mime_content_type($file['path']);
            header("Content-Type: $mime");
            readfile($file['path']);
            return true;
        }
        return false;
    }

    public function downloadFile(int $fileId): bool
    {
        $file = $this->getFile($fileId);
        if ($file) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Length: ' . filesize($file['path']));
            header('Pragma: no-cache');
            header('Expires: 0');
            readfile($file['path']);
            return true;
        }
        return false;
    }

    public function deleteById($id): bool
    {
        $file = $this->getFile($id);
        if ($file) {
            if (unlink($file['path'])) {
                return parent::deleteById($id);
            }
        }
        return false;
    }

    public function renameFile(int $fileId, string $newName): bool
    {
        return (bool)$this->query('UPDATE Files SET title = :Title
                            WHERE id = :FileId',
            [
                'FileId' => $fileId,
                'Title' => $newName
            ])->rowCount();
    }
}