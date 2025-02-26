<?php

namespace Core\Models;

class CourseModel extends Model
{
    protected string $table = 'Courses';

    public function __init_table(): void
    {
        // TODO: Refactor to follow this structure
        $this->query("CREATE TABLE IF NOT EXISTS Courses (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        imgId INT DEFAULT NULL,
                        name VARCHAR(255) UNIQUE NOT NULL,
                        description TEXT
                        FOREIGN KEY (imgId) REFERENCES Files(id)
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

    public function getCoursesForUser(int $accountId): array
    {
        return $this->query("SELECT c.id AS id,
                                          c.name AS name,
                                          c.description AS description,
                                          cu.approved AS approved,
                                          CASE
                                            WHEN cu.accountId IS NULL THEN FALSE
                                            ELSE TRUE
                                          END AS applied
                                   FROM Courses c
                                   LEFT JOIN Course_users cu ON c.id = cu.courseId AND cu.accountId = :AccountId", [
            "AccountId" => $accountId
        ])->fetchAll();
    }

    public function getCoursesWithUser(int $accountId): array
    {
        return $this->query("SELECT Course_users.courseId AS id,
                                          Courses.name AS name,
                                          Course_users.score AS score, 
                                          Course_users.approved AS approved
                                   FROM Course_users
                                   INNER JOIN Courses ON Course_users.courseId = Courses.id
                                   WHERE Course_users.accountId = :AccountId", [
            "AccountId" => $accountId
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

    public function addUserToCourse(int $accountId, int $courseId): int
    {
        $this->query("INSERT INTO Course_users (courseId, accountId) VALUES
                                                     (:CourseId, :AccountId)", [
            'CourseId' => $courseId,
            'AccountId' => $accountId
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
