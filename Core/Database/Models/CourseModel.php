<?php

namespace Core\Database\Models;

class CourseModel extends Model
{
    public function __init_table(): void
    {
        // TODO: Refactor to follow this structure
        $this->query("CREATE TABLE Courses (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        name VARCHAR(255) NOT NULL,
                        description TEXT
                    );");
    }
}