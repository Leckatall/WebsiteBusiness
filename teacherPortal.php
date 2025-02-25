<?php
// Include the necessary partials
require 'partials/header.php';
require 'partials/nav.php';
require 'partials/banner.php';
require 'partials/pitch.php';

// Include database connection
require 'database.php'; 
include 'teacherPortal.view.php';

// Fetch the courses from the database
$sql = "SELECT * FROM courses ORDER BY createdAt DESC";
$result = $conn->query($sql);

// Store the courses to pass to the view
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;  // Add each course to the array
    }
}

$conn->close(); // Close the connection

// Include the view and pass the courses to it

?>
