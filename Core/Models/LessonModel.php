<?php

namespace Core\Models;


class LessonModel extends Model
{
    protected string $table = 'Lessons';

    public function __init_table(): void
    {
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
                            accountId INT NOT NULL,
                            score INT DEFAULT 0,
                            FOREIGN KEY (lessonId) REFERENCES Lessons(id) ON DELETE CASCADE,
                            FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE
                        );');
    }


    public function getAllForCourse(int $courseId)
    {
        return $this->query("SELECT * FROM Lessons WHERE courseId = ?", [$courseId])->fetchAll();
    }

    public function getResultsForCourse(int $courseId, int $accountId)
    {
        return $this->query('SELECT l.id AS id,
                                   l.title AS title,
                                   l.description AS description,
                                   l.set_date AS set_date,
                                   l.due_date AS due_date,
                                   l.student_action AS student_action,
                                   lu.score
                            FROM Lessons l
                            LEFT JOIN Lesson_users lu ON lu.lessonId = l.id AND lu.accountId = :AccountId
                            WHERE l.courseId = :CourseId', [
            'AccountId' => $accountId,
            'CourseId' => $courseId
        ])->fetchAll();
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

    public function deleteLesson(int $lessonId): bool
    {
        return (bool)$this->query('DELETE FROM LESSONS WHERE id = :LessonId',[
            'LessonId' => $lessonId
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

    public function isUserInLesson(int $lessonId, int $accountId)
    {
        return !empty($this->query('SELECT * FROM Lesson_users WHERE lessonId = :LessonId AND accountId = :AccountId',
            [
                'LessonId' => $lessonId,
                'AccountId' => $accountId
            ])->fetchAll());
    }

    public function getStudentsForLesson(int $lessonId)
    {
        return $this->query("SELECT a.id AS id,
                                          a.email AS email,
                                          lu.score AS score
                                   FROM Lesson_users lu
                                   INNER JOIN Accounts a ON lu.accountId = a.id
                                   WHERE lu.lessonId = :LessonId 
                                   AND a.privilege_level = 1", ['LessonId' => $lessonId])->fetchAll();
    }

    public function registerToLesson(int $lessonId)
    {
        $accountId = $_POST['account_id'];
        if ($this->isUserInLesson($lessonId, $accountId)) {
            return false;
        }
        $this->query('INSERT INTO Lesson_users(lessonId, accountId) VALUES(:LessonId, :AccountId)',
            [
                'LessonId' => $lessonId,
                'AccountId' => $accountId
            ]);
        return $this->lastInsertId();
    }

    public function getLessonUser(int $lessonId, int $accountId)
    {
        return $this->query('SELECT * FROM Lesson_users WHERE lessonId = :LessonId AND accountId = :AccountId',
            [
                'LessonId' => $lessonId,
                'AccountId' => $accountId
            ])->fetch();
    }

    public function updateUserScore(int $lessonId, int $accountId, int $score): bool
    {
        return $this->query('UPDATE Lesson_users SET score = :Score WHERE lessonId = :LessonId AND accountId = :AccountId',[
            'LessonId' => $lessonId,
            'AccountId' => $accountId,
            'Score' => $score
        ])->rowCount();
    }

}
