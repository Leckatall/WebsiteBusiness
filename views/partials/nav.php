<?php
function navbar_link($title, $page)
{
    $active_page = $page == $_SERVER['REQUEST_URI'] ? "active" : "";
    return "<a class='nav-link $active_page' href='$page'>$title</a>";
}

?>

<header class="mb-auto">    
    <nav class="navbar navbar-expand-sm ms-auto w-30">
        <div class="container-fluid fs-6">
            <ul class="navbar-nav d-flex gap-2">
                <li class="nav-item"><?= navbar_link("Home", "/") ?></li>
                <li class="nav-item"><?= navbar_link("About", "/aboutUs") ?></li>

                <?php if ($_SESSION['user_id'] ?? false) : ?>
                    <li class="nav-item"><?= navbar_link("Portal", "/portal") ?></li>
                    <li class="nav-item"><?= navbar_link("Account", "/account?id={$_SESSION['user_id']}") ?></li>
                <?php else : ?>
                    <li class="nav-item"><?= navbar_link("Login", "/login") ?></li>
                <?php endif ?>
                <li class="nav-item"><?= navbar_link("Courses", "/courses") ?></li>
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

