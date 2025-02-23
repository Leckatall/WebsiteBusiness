
<?php //require 'partials/login_widget.php'?>

    <section class="heading container-fluid">
        <h1 class="title text-center ">Academy</h1>
        <hr>
        <h3 class="sub-title text-center">A educational hub for students and teachers</h3>
        <hr>
    </section>
    <section class="pitches">
    <?php require 'partials/pitch.php' ?>
    <?= make_pitch("Sophisticated and Personable Designs",
        "Personalisation to satisfy the perfectionist business owner <b>and </b> the care-free blogger",
        "LTR",
        "ChillingOnBoot.png",
        "Businesswoman") ?>

    <?= make_pitch("Engage your Audience",
        "Be they clients, fans or potential employers!",
        "RTL",
        "HangingOutWithController.jpg",
        "Technology Interaction") ?>
    </section>

