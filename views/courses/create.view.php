
<main>
<div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
    <form method="POST" action="/courses">
        <label for="name">Course Name</label>
        <div>
            <textarea id="name" name="name" required><?= $_POST['name'] ?? ''?></textarea>
            <?php if (isset($errors['name'])) : ?>
                <p class="text-red-500 text-xs mt-2"><?= $errors['name'] ?></p>
            <?php endif; ?>
        </div>
        <label for="desc">Course Description</label>
        <div>
            <textarea id="desc" name="description" required><?= $_POST['description'] ?? ''?></textarea>
            <?php if (isset($errors['description'])) : ?>
                <p class="text-red-500 text-xs mt-2"><?= $errors['description'] ?></p>
            <?php endif; ?>
        </div>
        <p>
            <button type="submit">
                Add Course
            </button>
        </p>
    </form>
</div>
</main>

