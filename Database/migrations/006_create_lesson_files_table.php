<?php

$db = \Core\Database::getInstance()->getConnection();

$db->exec("CREATE TABLE IF NOT EXISTS Lesson_files (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            lessonId INT NOT NULL,
                            fileId INT NOT NULL,
                            FOREIGN KEY (lessonId) REFERENCES Lessons(id) ON DELETE CASCADE,
                            FOREIGN KEY (fileId) REFERENCES Files(id) ON DELETE CASCADE
                        );");