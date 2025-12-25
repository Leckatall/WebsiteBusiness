<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;
    private array $config;

    public function __construct($config, $username = null, $password = null) {
        $this->config = $config;
        $username = $username ?? $config['username'] ?? 'root';
        $password = $password ?? $config['password'] ?? '';

        $this->connection = $this->createConnection($username, $password);
    }

    private function createConnection($username, $password): PDO {
        // Try to connect to the specific database first
        try {
            $dsn = $this->buildDsn(true);
            return new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            // If database doesn't exist, create it
            if ($this->isDatabaseNotFoundError($e)) {
                $this->createDatabase($username, $password);
                // Now connect to the newly created database
                $dsn = $this->buildDsn(true);
                return new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC
                ]);
            }
            throw $e;
        }
    }

    private function buildDsn($includeDbName = true): string {
        $params = [
            'host' => $this->config['host'],
            'port' => $this->config['port'],
            'charset' => $this->config['charset']
        ];

        if ($includeDbName) {
            $params['dbname'] = $this->config['dbname'];
        }

        return 'mysql:' . http_build_query($params, '', ';');
    }

    private function isDatabaseNotFoundError(PDOException $e): bool {
        return $e->getCode() === 1049; // MySQL "Unknown database" error
    }

    private function createDatabase($username, $password): void {
        echo "Database '{$this->config['dbname']}' not found. Creating...\n";

        // Connect without specifying database
        $dsn = $this->buildDsn(false);
        $tempConnection = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION
        ]);

        // Create the database
        $dbname = $this->config['dbname'];
        $tempConnection->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        echo "Database '$dbname' created successfully!\n";
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
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


