<?php

namespace Core\Database\Models;

class CourseModel extends Model
{
    protected string $table = 'Courses';

    public function __init_table(): void
    {
        // TODO: Refactor to follow this structure
        $this->query("CREATE TABLE IF NOT EXISTS Courses (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        name VARCHAR(255) UNIQUE NOT NULL,
                        description TEXT
                    );");
        //Score?
        // Unsure about potentially using a composite primary key of userId and courseId
        $this->query("CREATE TABLE IF NOT EXISTS Course_users (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        accountId INT NOT NULL,
                        courseId INT NOT NULL,
                        score INT NOT NULL DEFAULT 0,
                        approved BOOLEAN NOT NULL DEFAULT FALSE,
                        FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE,
                        FOREIGN KEY (courseId) REFERENCES Courses(id) ON DELETE CASCADE
                    );");
    }

    public function getUserIdsForCourse(int $courseId): array
    {
        return $this->query("SELECT accountId FROM Course_users WHERE courseId = :CourseId", [
            "CourseId" => $courseId
        ])->fetchAll();
    }

    /**
     * @param int $courseId PK from Courses
     * @return array
     */
    public function getUsersForCourse(int $courseId): array
    {
        return $this->query("SELECT course_users.accountId AS id,
                                          accounts.email AS email,
                                          accounts.privilege_level AS privilege_level,
                                          course_users.score AS score, 
                                          course_users.approved AS approved
                                   FROM Course_users
                                   INNER JOIN accounts ON Course_users.accountId = accounts.id
                                   WHERE courseId = :CourseId", [
            "CourseId" => $courseId
        ])->fetchAll();
    }

    public function isUserInCourse(int $accountId, int $courseId): bool
    {
        return (bool) count($this->query("SELECT * FROM Course_users
                                                WHERE courseId = :CourseId
                                                AND accountId = :AccountId", [
                                                    "CourseId" => $courseId,
                                                    "AccountId" => $accountId
        ])->fetchAll());
    }

    public function courseExists(string $title): bool
    {
        return !empty($this->query("SELECT id FROM Courses WHERE title = :Title", [
            "Title" => $title
        ])->fetchAll());
    }

    public function addCourse(string $name, string $description, int $tutorId): int
    {
        $this->query("INSERT INTO Courses (name, description) VALUES 
                                                (:Name, :Description)", [
            'Name' => $name,
            'Description' => $description
        ]);
        $courseId = $this->lastInsertId();

        // Add the tutor into their own course
        $this->query("INSERT INTO Course_users (courseId, accountId, approved) VALUES
                                                 (:CourseId, :AccountId, :Approved)", [
            'CourseId' => $courseId,
            'AccountId' => $tutorId,
            'Approved' => true
        ]);

        return $courseId;
    }

    public function canEditCourse(int $courseId, int $userId): bool
    {
        //TODO: Only tutors who are part of the course can edit it
        return ((new AccountModel)->getById($userId)['privilege_level'] >= 2);
    }

    public function updateCourse(int $id, string $name, string $description): bool
    {
        $this->query("UPDATE Courses SET name = :Name,
                                               description = :Description WHERE
                                               id = :Id", [
            'Name' => $name,
            'Description' => $description,
            'Id' => $id
        ]);
    }

    public function addUserToCourse(int $userId, int $courseId): int
    {
        $this->query("INSERT INTO Course_users (courseId, userId) VALUES
                                                     (:courseId, :userId)", [
            'courseId' => $courseId,
            'userId' => $userId
        ]);
        return $this->lastInsertId();
    }

    public function approveUserToCourse(int $courseId, int $userId)
    {
        $this->query('UPDATE Courses SET approved = TRUE WHERE 
                                           id = :courseId AND
                                           userId = :userId', [
            'courseId' => $courseId,
            'userId' => $userId
        ]);
    }
}
