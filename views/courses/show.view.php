<main class="m-5">
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <h3><?= htmlspecialchars($course["description"]) ?></h3>
    </div>
    <a href="/courses/<?= $course['id'] ?>/edit">Edit Course</a>
    <a href="/courses/<?= $course['id'] ?>/users">View participants</a>
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


