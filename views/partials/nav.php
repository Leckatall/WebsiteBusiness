<?php
function navbar_link($title, $page)
{
    $active_page = $page == $_SERVER['REQUEST_URI'] ? "active" : "";
    return "<a class='nav-link $active_page' href='$page'>$title</a>";
}

?>

<header class="mb-auto">
    <div class="image-container">
        <img class="float-md-start" alt="chilling" src=<?= get_image_src("HangingOutWithController.jpg") ?>>
    </div>
    <nav class="navbar navbar-expand-sm">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item"><?= navbar_link("Home", "/") ?></li>
                <li class="nav-item"><?= navbar_link("About", "/aboutUs") ?></li>
                <?php load_partial('nav-portal-selector.php') ?>
                <li class="nav-item"><?= navbar_link("Courses", "/courses") ?></li>
                <li>
                    <button onclick="document.getElementById('login_widget').style.display='block'">LoginM8</button>
                </li>
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

