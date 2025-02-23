<?php
// db.php - Database connection

$servername = "localhost";
$username = "root"; // Default username in Uniform Server
$password = ""; // Default password is empty in Uniform Server
$dbname = "createdCourses"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
