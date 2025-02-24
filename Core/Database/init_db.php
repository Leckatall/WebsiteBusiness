<?php

namespace Core\Database;

use PDO;

public function _init_db__($config, $username='root', $password=''){
    // TODO: run once to set up all the tables
    $dsn = 'mysql:'. http_build_query($config, '', ';');

    $connection = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $connection->prepare("CREATE TABLE IF NOT EXISTS Accounts (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` text NOT NULL,
  `Password` text NOT NULL,
  `PrivilegeLvl` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
");
}