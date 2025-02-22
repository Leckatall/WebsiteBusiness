<?php
$servername = "localhost";
$dbname = "liverpool_hope";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create admin user if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
    $stmt->execute();

    if ($stmt->fetchColumn() == 0) {
        $admin_password = password_hash('Admin@123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Admin User', 'admin@liverpool.hope.edu', $admin_password, 'admin']);
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>