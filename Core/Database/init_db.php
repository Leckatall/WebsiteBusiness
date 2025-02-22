<?php

namespace Core\Database;

public function _init_db__($config, $username='root', $password=''){
    // TODO: run once to set up all the tables
    $dsn = 'mysql:'. http_build_query($config, '', ';');

    $connection = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $connection->prepare("CREATE TABLE IF NOT EXISTS");
}