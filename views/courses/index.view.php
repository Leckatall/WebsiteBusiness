
<?php require base_path('/views/partials/header.php') ?>

<?php require base_path('/views/partials/nav.php') ?>

<?php require base_path('/views/partials/banner.php') ?>
<?php require base_path('/views/partials/pitch.php')?>


<main>
<div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
    <ul>
    <?php foreach ($courses as $course): ?>
     <li>
         <a href="/course?id=<?= htmlspecialchars($course['Id']) ?>">
            <?= $course['Name'] ?>
         </a>
     </li>
    <?php endforeach ?>
    </ul>
    <p class="mt-6">
        <a href="/courses/create" class="text-blue-500 hover:underline">Add Course</a>
    </p>
</div>
</main>


<?php require base_path('/views/partials/footer.php') ?>


