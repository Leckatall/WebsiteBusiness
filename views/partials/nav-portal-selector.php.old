<?php
$links_by_priv = [
    ['Title' => 'Login', 'Link' => '/login'],
    ['Title' => 'Student Portal', 'Link' => '/student-portal?id='],
    ['Title' => 'Tutor Portal', 'Link' => '/tutor-portal?id='],
    ['Title' => 'Admin Portal', 'Link' => '/admin-portal?id=']
];
$priv = $_SESSION['user']['privilege_level'] ?? 0;
$usrId = $_SESSION['user']['id'] ?? "";
?>


<li class="nav-item">
    <?= navbar_link($links_by_priv[$priv]['Title'],
        "{$links_by_priv[$priv]['Link']}$usrId") ?>
</li>
<?php if ($_SESSION['logged_in']) : ?>
    <li class="nav-item">
        <?= navbar_link("Your Account",
            "/account?id=$usrId") ?>
    </li>
<?php endif ?>
