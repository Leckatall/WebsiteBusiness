<?php

namespace Core\Models;

class CourseModel extends Model
{
    protected string $table = 'Courses';

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
    public function getUsers(int $courseId): array
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
        // gets all courses with reference to the current users status in that course (applied, pending, participant)
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
        // get courses the user is in
        return $this->query("SELECT Course_users.courseId AS id,
                                          Courses.name AS name,
                                          Course_users.score AS score, 
                                          Course_users.approved AS approved
                                   FROM Course_users
                                   INNER JOIN Courses ON Course_users.courseId = Courses.id
                                   WHERE Course_users.accountId = :AccountId
                                   AND Course_users.approved = 1", [
            "AccountId" => $accountId
        ])->fetchAll();
    }

    public function isUserInCourse(int $accountId, int $courseId): bool
    {
        return (bool)count($this->query("SELECT * FROM Course_users
                                                WHERE courseId = :CourseId
                                                AND accountId = :AccountId", [
            "CourseId" => $courseId,
            "AccountId" => $accountId
        ])->fetchAll());
    }

    public function courseExists(string $name): bool
    {
        return !empty($this->query("SELECT id FROM Courses WHERE name = :Name", [
            "Name" => $name
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


    public function updateCourse(int $id, string $name, string $description): bool
    {
        return (bool)$this->query("UPDATE Courses SET name = :Name,
                                               description = :Description 
                            WHERE id = :Id", [
            'Name' => $name,
            'Description' => $description,
            'Id' => $id
        ])->rowCount();
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

    public function approveUserToCourse(int $courseId, int $userId): bool
    {
        return (bool)$this->query('UPDATE Course_users SET approved = TRUE WHERE 
                                           courseId = :CourseId AND
                                           accountId = :AccountId', [
            'CourseId' => $courseId,
            'AccountId' => $userId
        ])->rowCount();
    }

    public function removeUserFromCourse(int $courseId, int $userId): bool
    {
        return (bool)$this->query('DELETE FROM Course_users WHERE courseId = :CourseId AND accountId = :AccountId',
            [
                'CourseId' => $courseId,
                'AccountId' => $userId
            ])->rowCount();
    }
}
