<section class="teacherPortal">
  <h1>Access Created Courses</h1>
  
  <?php if (count($courses) > 0): ?>
    <!-- Loop through the courses and display them -->
    <div class="courses-list">
      <?php foreach ($courses as $course): ?>
        <div class="course-item">
          <h3><?php echo htmlspecialchars($course['courseTitle']); ?></h3>
          <p><?php echo htmlspecialchars($course['courseDescription']); ?></p>
          <p><em>Created on: <?php echo date('F j, Y', strtotime($course['createdAt'])); ?></em></p>
          <a href="course_details.php?id=<?php echo $course['id']; ?>" class="btn btn-info">View Course</a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>No courses created yet.</p>
  <?php endif; ?>

  <!-- Link to go to the Create Course page -->
  <div class="create-course">
    <h2>Create a New Course</h2>
    <a href="createCourse.php" class="btn btn-primary">Create Course</a>
  </div>
</section>
