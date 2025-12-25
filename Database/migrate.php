<?php

class MigrationRunner
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = \Core\Database::getInstance()->getConnection();
        $this->createMigrationsTable();
    }

    private function createMigrationsTable()
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT PRIMARY KEY AUTO_INCREMENT,
                migration VARCHAR(255) NOT NULL,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function run()
    {
        $files = glob(__DIR__ . '/migrations/*.php');
        sort($files);

        $executed = $this->getExecutedMigrations();

        foreach ($files as $file) {
            $migration = basename($file);

            if (!in_array($migration, $executed)) {
                echo "Running:  $migration\n";
                require $file;
                $this->markAsExecuted($migration);
                echo "Completed: $migration\n";
            }
        }
    }

    private function getExecutedMigrations(): array
    {
        $stmt = $this->db->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function markAsExecuted(string $migration)
    {
        $stmt = $this->db->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$migration]);
    }
}

// Run migrations
$runner = new MigrationRunner();
$runner->run();
echo "All migrations completed!\n";


