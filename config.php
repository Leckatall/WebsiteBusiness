<?php

return [
    'database' => [
        'host' => $_ENV['DB_HOST'] ??  'localhost',
        'port' => $_ENV['DB_PORT'] ?? 3306,
        'dbname' => $_ENV['DB_NAME'] ?? 'Academy',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? '',
        'charset' => 'utf8mb4'
    ]
];