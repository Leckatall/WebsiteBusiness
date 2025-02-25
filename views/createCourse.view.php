<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
</head>
<body>

<h2>Create a New Course</h2>

<!-- Form to create a new course -->
<form action="createCourse.php" method="POST">
    <div>
        <label for="courseTitle">Course Title:</label>
        <input type="text" id="courseTitle" name="courseTitle" required>
    </div>

    <div>
        <label for="courseDescription">Course Description:</label>
        <textarea id="courseDescription" name="courseDescription" required></textarea>
    </div>

    <button type="submit" name="submitCourseForm">Create Course</button>
</form>

</body>
</html>