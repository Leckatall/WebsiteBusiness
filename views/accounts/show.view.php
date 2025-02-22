<?php require base_path('/views/partials/header.php') ?>

<?php require base_path('/views/partials/nav.php') ?>

<?php require base_path('/views/partials/banner.php') ?>
<?php require base_path('/views/partials/pitch.php') ?>


<main>
    <div class='mx-auto max-w-7xl py-6 sm:px-6 lg:px-8'>
        <h1>The Course Page for <?= htmlspecialchars($account["Email"]) ?></h1>
    </div>
    <form method="POST">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="<?= $account['Id'] ?>">
        <button class="text-sm text-red-500">DELETE COURSE</button>
    </form>
</main>

<?php require base_path('/views/partials/footer.php') ?>
