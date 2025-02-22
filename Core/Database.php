<?php

namespace Core;

use PDO;

class Database {
    public PDO $connection;

    public function __construct($config, $username='root', $password='') {
        $dsn = 'mysql:'. http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
    }
    public function query($query, $params = []){
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    public function getLastInsertId(){
        return $this->connection->lastInsertId();
    }

}


