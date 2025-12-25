<?php

echo "Setting up WebsiteBusiness.. .\n\n";

// Load environment variables if using a .env
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

require_once 'Core/bootstrap.php';

try {
    echo "Connecting to the  database...\n";
    $db = \Core\Database::getInstance();
    echo "Database connection established!\n\n";

    echo "Running migrations...\n";
    require_once 'Database/migrate.php';

    // Optional:  Seed data
    if (file_exists('database/seeds/initial_data.php')) {
        echo "\nSeeding initial data...\n";
        require_once 'database/seeds/initial_data.php';
        echo "Seeding complete!\n";
    }

    echo "\nSetup complete!\n";

} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "\n";
    echo "💡 Check your database credentials in . env file\n";
    exit(1);
}