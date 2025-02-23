<?php
// Controller for creating courses
require 'database.php';
require 'partials/header.php';
require 'partials/nav.php';

if (isset($_POST['submitCourseForm'])) {
  // Get the data from the form and sanitize it
  $courseTitle = htmlspecialchars($_POST['courseTitle']);
  $courseDescription = htmlspecialchars($_POST['courseDescription']);

  // Insert the course data into the "courses" table
  $sql = "INSERT INTO courses (courseTitle, courseDescription) VALUES ('$courseTitle', '$courseDescription')";

  // Execute the query and check if it was successful
  if ($conn->query($sql) === TRUE) {
      // Redirect to the teacher portal after successful insertion
      header("Location: teacherPortal.php");
      exit();
  } else {
      // If there's an error, display it
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
// Include the view to display the form
require 'views/createCourse.view.php';
require 'partials/footer.php';
?>

