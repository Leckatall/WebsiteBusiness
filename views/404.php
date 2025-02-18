<?php require 'partials/header.php' ?>

<?php require 'partials/nav.php' ?>

<main>
    <div class="mx-auto max-w-7xl py-6 sm:py-6 lg:px-8">
        <h1 class="text-2xl font-bold">
            404 - Page Not Found
        </h1>
        <p class="mt-4">
            <a href="/", class="text-blue underline">Home Page</a>
        </p>

    </div>

</main>
    <section class="heading container-fluid">
        <h1 class="title text-center ">Hathor Website Design</h1>
        <h3 class="sub-title text-center">Share Your Dream</h3>
        <hr >
    </section>

    <section class="pitches">
    <?php require 'partials/pitch.php' ?>
    <?= make_pitch("Sophisticated and Personable Designs",
        "Personalisation to satisfy the perfectionist business owner <b>and </b> the care-free blogger",
        "LTR",
        "/images/HappyLaptopWoman.jpg",
        "Businesswoman") ?>

    <?= make_pitch("Engage your Audience",
        "Be they clients, fans or potential employers!",
        "RTL",
        "/images/InteractingWithTechnology.jpg",
        "Technology Interaction") ?>
    </section>

<?php require 'partials/footer.php' ?>
