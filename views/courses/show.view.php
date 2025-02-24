<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <h1>The Course Page for <?= htmlspecialchars($course["name"]) ?></h1>
    </div>
    <a href="course/edit?id=<?= $course['id'] ?>">Edit Course</a>
    <a href="course/users?course_id=<?= $course['id'] ?>">View participants</a>
    <?php if ($isParticipant) : ?>

        <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
            <h2>Lesson List</h2>
            <a href="/lessons/create?courseId=<?= $course['id'] ?>">Add a Lesson</a>
            <ul>
                <?php foreach ($lessons as $lesson): ?>
                    <li>
                        <a href="/lesson?id=<?= htmlspecialchars($lesson['id']) ?>">
                            <?= $lesson['title'] ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php else : ?>
        <form method="POST" action="/course/users">
            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
            <button type="submit">Apply</button>
        </form>
    <?php endif ?>
</main>


