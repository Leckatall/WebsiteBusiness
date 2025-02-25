
<?php //require 'partials/login_widget.php'?>

    <section class="heading container-fluid mt-5">
        <h1 class="title text-center">Academy</h1>

        <h3 class="sub-title text-center">An educational hub for students and teachers</h3>
        <hr>
    </section>

    <section class="pitches">
    <?php require 'partials/pitch.php' ?>
    <?= make_pitch("Sophisticated and Personable Designs",
        "Personalisation to satisfy the perfectionist business owner <b>and </b> the care-free blogger",
        "LTR",
        "HappyLaptopWoman.jpg",
        "Businesswoman") ?>

    <?= make_pitch("Engage your Audience",
        "Be they clients, fans or potential employers!",
        "RTL",
        "InteractingWithTechnology.jpg",
        "Technology Interaction") ?>
    </section>

