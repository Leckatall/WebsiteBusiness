<?php

namespace Core;

use PDO;

class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    public function __construct($config, $username='root', $password='') {
        $dsn = 'mysql:'. http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
    }
    public static function getInstance(): Database
    {
        if(!self::$instance){
            $config = require_once base_path('config.php');
            self::$instance = new Database($config['database']);
        }
        return self::$instance;
    }
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}


