<?php

$db = \Core\Database::getInstance()->getConnection();

$db->exec("CREATE TABLE IF NOT EXISTS Course_users (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        accountId INT NOT NULL,
                        courseId INT NOT NULL,
                        score INT NOT NULL DEFAULT 0,
                        approved BOOLEAN NOT NULL DEFAULT FALSE,
                        FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE,
                        FOREIGN KEY (courseId) REFERENCES Courses(id) ON DELETE CASCADE
                    );");


//  TODO? Better Table design Project Over tho so gonna focus on adapting this website into a different one
//        CREATE TABLE Course_enrollments (
//        id INT PRIMARY KEY AUTO_INCREMENT,
//    accountId INT NOT NULL,
//    courseId INT NOT NULL,
//    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//    status ENUM('pending', 'active', 'completed', 'suspended') DEFAULT 'pending',
//    UNIQUE KEY unique_enrollment (accountId, courseId),
//    FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE,
//    FOREIGN KEY (courseId) REFERENCES Courses(id) ON DELETE CASCADE
//);