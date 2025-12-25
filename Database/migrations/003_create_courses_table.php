<?php

$db = \Core\Database::getInstance()->getConnection();

$db->exec("CREATE TABLE IF NOT EXISTS Courses (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        imgId INT DEFAULT NULL,
                        name VARCHAR(255) UNIQUE NOT NULL,
                        description TEXT,
                        FOREIGN KEY (imgId) REFERENCES Files(id)
                    );");
