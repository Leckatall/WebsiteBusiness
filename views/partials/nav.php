<?php
function navbar_link($title, $page): string
{
    $active_page = $page == $_SERVER['REQUEST_URI'] ? "active" : "";
    return "<a class='nav-link $active_page' href='$page'>$title</a>";
}

?>

<header class="mb-auto">
    <nav class="navbar navbar-expand-sm mx-auto">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item"><?= navbar_link("Home", "/") ?></li>
                <li class="nav-item"><?= navbar_link("About", "/aboutUs") ?></li>
                <?php if ($_SESSION['logged_in']) : ?>
                    <li class="nav-item"><?= navbar_link("Portal", "/portal") ?></li>
                    <li class="nav-item">
                        <?= navbar_link("Your Account",
                            "/accounts/{$_SESSION['user']['id']}") ?>
                    </li>
                    <li class="nav-item"><?= navbar_link("Courses", "/courses") ?></li>
                <?php else : ?>
                    <li class="nav-item"><?= navbar_link("Login", "/login") ?></li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
</header>
<!--<header class="mb-auto">-->
<!--    <div>-->
<!--        <h3 class="float-md-start mb-0">Hathor</h3>-->
<!--        <nav class="nav nav-masthead justify-content-center float-md-end">-->
<!--            <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="#">Home</a>-->
<!--            <a class="nav-link fw-bold py-1 px-0" href="#">Features</a>-->
<!--            <a class="nav-link fw-bold py-1 px-0" href="#">Contact</a>-->
<!--        </nav>-->
<!--    </div>-->
<!--</header>-->

