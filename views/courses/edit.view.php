
<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <form method="POST" action="/course">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="course_id" value="<?= $course['id']; ?>">
            <label for="name">Course Name</label>
            <div>
                <textarea id="name" name="name" required><?= $course['name'] ?? $_POST['name'] ?? '' ?></textarea>
                <?php if (isset($errors['name'])) : ?>
                    <p class="text-red-500 text-xs mt-2"><?= $errors['name'] ?></p>
                <?php endif; ?>
            </div>
            <label for="desc">Course Description</label>
            <div>
                <textarea id="desc" name="description"
                          required><?= $course['description'] ?? $_POST['description'] ?? '' ?></textarea>
                <?php if (isset($errors['description'])) : ?>
                    <p class="text-red-500 text-xs mt-2"><?= $errors['description'] ?></p>
                <?php endif; ?>
            </div>
            <p>
                <a href="/course?id=<?= $course['id'] ?>">Back</a>
                <button type="reset">Reset</button>
                <button type="submit">Update Course</button>
            </p>
        </form>
        <form method="POST" action="/course">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
        <button class="text-sm text-red-500">Delete Course</button>
    </form>
    </div>
</main>
