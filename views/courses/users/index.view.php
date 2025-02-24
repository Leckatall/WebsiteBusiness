<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <a href="/course?id=<?= $_GET['course_id'] ?>">Back to course</a>
        <?php load_partial('course_users_table.php', ['accounts' => $course_users]) ?>
    </div>
</main>
