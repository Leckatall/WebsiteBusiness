<?php

namespace Core\Models;

use Core\Database;

class Model
{
    protected \PDO $connection;
    // override to enable common queries
    protected string $table;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    protected function query($query, $params = [])
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    public function getAll()
    {
        return $this->query("SELECT * FROM $this->table")->fetchAll();
    }

    public function getById($id)
    {
        return $this->query("SELECT * FROM $this->table WHERE id = ?", [$id])->fetch();
    }

    public function getByIds(array $ids): array
    {
        $values = [];
        foreach ($ids as $id) {
            $values[] = $this->getById($id);
        }
        return $values;
    }

    public function deleteById($id): bool
    {
        return (bool)$this->query("DELETE FROM $this->table WHERE id = ?", [$id])->rowCount();
    }

    public function count()
    {
        return count($this->getAll());
    }

    public function lastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }
}
