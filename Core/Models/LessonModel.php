<?php

namespace Core\Models;


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
                            description TEXT NOT NULL,
                            set_date DATE NOT NULL,
                            due_date DATE,
                            student_action INT DEFAULT 0,
                            FOREIGN KEY (courseId) REFERENCES Courses(id) ON DELETE CASCADE
                    );');
        $this->query('CREATE TABLE IF NOT EXISTS Lesson_files (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            lessonId INT NOT NULL,
                            fileId INT NOT NULL,
                            FOREIGN KEY (lessonId) REFERENCES Lessons(id) ON DELETE CASCADE,
                            FOREIGN KEY (fileId) REFERENCES Files(id) ON DELETE CASCADE
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
        return $this->query("SELECT * FROM Lessons WHERE courseId = ?", [$courseId])->fetchAll();
    }

    public function addLesson(int $courseId, string $title, string $description, $setDate, $dueDate): int
    {
        $this->query('INSERT INTO LESSONS(courseId, title, description, set_date, due_date) 
                            VALUES(:CourseId, :Title, :Description, :SetDate, :DueDate)',
            [
                'CourseId' => $courseId,
                'Title' => $title,
                'Description' => $description,
                'SetDate' => $setDate,
                'DueDate' => $dueDate
            ]);
        return $this->lastInsertId();
    }

    public function updateLesson(int $lessonId, int $courseId, string $title, string $description, $setDate, $dueDate, int $studentAction): bool
    {
        return (bool)$this->query('UPDATE LESSONS SET courseId = :CourseId,
                                               title = :Title,
                                               description = :Description,
                                               set_date = :SetDate,
                                               due_date = :DueDate,
                                               student_action = :StudentAction
                            WHERE id = :LessonId',
            [
                'LessonId' => $lessonId,
                'CourseId' => $courseId,
                'Title' => $title,
                'Description' => $description,
                'SetDate' => $setDate,
                'DueDate' => $dueDate,
                'StudentAction' => $studentAction
            ])->rowCount();
    }

    public function addFile(int $lessonId, int $fileId): int
    {
        $this->query('INSERT INTO Lesson_files(lessonId, fileId) VALUES(:LessonId, :FileId)',
            [
                'LessonId' => $lessonId,
                'FileId' => $fileId
            ]);
        return $this->lastInsertId();
    }
}
