
<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <h1>The Course Page for <?= htmlspecialchars($course["Name"]) ?></h1>
    </div>
    <form method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $course['Id'] ?>">
        <button class="text-sm text-red-500">DELETE COURSE</button>
    </form>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <h2>Lesson List</h2>
        <a href="/courses/lessons/create?courseId=<?= $course['Id'] ?>">Add a Lesson</a>
        <ul>
            <?php foreach ($lessons as $lesson): ?>
                <li>
                    <a href="/lesson?id=<?= htmlspecialchars($lesson['Id']) ?>">
                        <?= $lesson['Title'] ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</main>


