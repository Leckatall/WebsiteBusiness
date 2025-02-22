<?php require base_path('/views/partials/header.php') ?>

<?php require base_path('/views/partials/nav.php') ?>

<?php require base_path('/views/partials/banner.php') ?>
<?php require base_path('/views/partials/pitch.php')?>


<main>
<div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
    <form method="POST" action="/courses">
        <label for="courseTitle">Course Title</label>
        <div>
            <textarea id="courseTitle" name="name" required><?= $_POST['name'] ?? ''?></textarea>
            <?php if (isset($errors['body'])) : ?>
                <p class="text-red-500 text-xs mt-2"><?= $errors['body'] ?></p>
            <?php endif; ?>
        </div>
        <p>
<!--            send them smwhere after they click submit-->
            <button type="submit">
                Add Course
            </button>
        </p>
    </form>
</div>
</main>

<?php require base_path('/views/partials/footer.php') ?>
