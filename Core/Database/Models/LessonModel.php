<?php

namespace Core\Database\Models;


class LessonModel extends Model
{
    protected string $table = 'Lessons';
    public function __init_table(): void
    {
        // TODO: Refactor to follow this structure
        $this->query('CREATE TABLE IF NOT EXISTS Lessons (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            courseId INT NOT NULL,
                            title VARCHAR(255) NOT NULL,
                            description TEXT,
                            set_date DATE NOT NULL,
                            due_date DATE,
                            FOREIGN KEY (courseId) REFERENCES Courses(id) ON DELETE CASCADE
                    );');
        $this->query('CREATE TABLE IF NOT EXISTS Lesson_files (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            lessonId INT NOT NULL,
                            file_name VARCHAR(255) NOT NULL,
                            file_path VARCHAR(255) NOT NULL,
                            FOREIGN KEY (lessonId) REFERENCES Lessons(id) ON DELETE CASCADE
                        );');
        // For storing student progress
        $this->query('CREATE TABLE IF NOT EXISTS Lesson_users (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            lessonId INT NOT NULL,
                            file_name VARCHAR(255) NOT NULL,
                            file_path VARCHAR(255) NOT NULL,
                            FOREIGN KEY (lessonId) REFERENCES Lessons(id) ON DELETE CASCADE
                        );');

    }

    public function getAllForCourse(int $courseId)
    {
        return $this->query("SELECT * FROM Lessons WHERE courseId = ?", [$courseId]);
    }

    public function addLesson(int $courseId, string $title, string $description, $setDate, $dueDate): int
    {
        $this->query('INSERT INTO LESSONS(Id, Title, Description, SetDate, DueDate) 
                            VALUES(:lessonId, :userId, :title, :description, :setDate, :dueDate)', [
            'courseId' => $courseId,
            'title' => $title,
            'description' => $description,
            'setDate' => $setDate,
            'dueDate' => $dueDate
        ]);
        return $this->lastInsertId();
    }

    public function addFiles(int $lessonId, string $fileName, string $filePath): int
    {
        $this->query('INSERT INTO LessonFiles(LessonId, FileName, FilePath) VALUES(:lessonId, :fileName, :filePath)',
            [
                'lessonId' => $lessonId,
                'fileName' => $fileName,
                'filePath' => $filePath
            ]);
        return $this->lastInsertId();
    }
}
