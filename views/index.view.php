<?php require 'partials/header.php' ?>

<?php require 'partials/nav.php' ?>

    <section class="heading">
        <h1 class="title center">Hathor Website Design</h1>
        <h3 class="sub-title center">Share Your Dream</h3>
        <hr width="100%" class="center">
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
