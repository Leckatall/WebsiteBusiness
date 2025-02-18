
<?php require base_path('/views/partials/header.php') ?>

<?php require base_path('/views/partials/nav.php') ?>

<?php require base_path('/views/partials/banner.php') ?>
<?php require base_path('/views/partials/pitch.php')?>


<main>
<div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
    <?php foreach ($courses as $course): ?>
     <li>
         <a href="/course?id=<?= $course['Id'] ?>">
            <?= $course['Name'] ?>
         </a>
     </li>
    <?php endforeach ?>
</div>
</main>





