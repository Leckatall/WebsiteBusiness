<?php

namespace Core\Database\Models;

use Core\Database\Database;

class Model
{
    protected $connection;
    // override to enable common queries
    protected string $table;

    public function __construct() {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function query($query, $params = []){
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    public function getAll(){
        return $this->query("SELECT * FROM {$this->table}")->fetchAll();
    }

    public function getById($id){
        return $this->query("SELECT * FROM {$this->table} WHERE Id = ?", [$id])->fetchAll();
    }
    public function count(){
        return count($this->getAll());
    }
}