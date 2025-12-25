<?php

$db = \Core\Database::getInstance()->getConnection();

$db->exec("
    CREATE TABLE IF NOT EXISTS Files (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            accountId INT NOT NULL,
                            title VARCHAR(255) NOT NULL,
                            path VARCHAR(255) NOT NULL,
                            uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            FOREIGN KEY (accountId) REFERENCES Accounts(id) ON DELETE CASCADE
                    );");
