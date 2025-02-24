<?php

namespace Core\Database\Models;


class LessonModel extends Model
{
    public function __init_table(): void
    {
        // TODO: Refactor to follow this structure
        $this->query("CREATE TABLE Lessons (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            course_id INT NOT NULL,
                            name VARCHAR(255) NOT NULL,
                            description TEXT,
                            set_date DATE NOT NULL,
                            due_date DATE,
                            FOREIGN KEY (course_id) REFERENCES Courses(id) ON DELETE CASCADE
                    );");
    }

}