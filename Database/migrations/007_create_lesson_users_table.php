<?php

$db = \Core\Database::getInstance()->getConnection();

$db->exec("CREATE TABLE IF NOT EXISTS Lesson_users (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            lessonId INT NOT NULL,
                            accountId INT NOT NULL,
                            score INT DEFAULT 0,
                            FOREIGN KEY (lessonId) REFERENCES Lessons(id) ON DELETE CASCADE,
                            FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE
                        );");