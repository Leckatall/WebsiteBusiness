<?php

$db = \Core\Database::getInstance()->getConnection();

$db->exec(
    "CREATE TABLE IF NOT EXISTS Accounts (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            email VARCHAR(255) UNIQUE NOT NULL,
                            password_hash VARCHAR(255) NOT NULL,
                            privilege_level INT NOT NULL,
                            approved BOOLEAN DEFAULT FALSE
                    );"
);
