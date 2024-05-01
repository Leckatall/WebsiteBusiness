<?php include 'functions.php'; ?>

<?php
function navbar_link($title, $page){
    $active_page = $page == $_SERVER['REQUEST_URI'] ? "class=active-page" : "";
    return "<a $active_page href='$page'>$title</a>";
}
?>

<header class="navbar-container">
    <nav class="navbar">
        <img src="/images/HangingOutWithController.jpg" alt="chilling" >
        <ul>
            <li><?= navbar_link("Home", "/")?></li>
            <li><?= navbar_link("About", "/aboutUs.php")?></li>
            <li><?= navbar_link("Templates", "/templates.php")?></li>
        </ul>
    </nav>
</header>


