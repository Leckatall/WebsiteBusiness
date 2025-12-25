<?php

$db = \Core\Database::getInstance()->getConnection();

$db->exec("CREATE TABLE IF NOT EXISTS Lessons (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            courseId INT NOT NULL,
                            title VARCHAR(255) NOT NULL,
                            description TEXT NOT NULL,
                            set_date DATE NOT NULL,
                            due_date DATE,
                            student_action INT DEFAULT 0,
                            FOREIGN KEY (courseId) REFERENCES Courses(id) ON DELETE CASCADE
                    );");