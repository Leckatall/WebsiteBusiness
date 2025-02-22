<?php

$portals  = [
    1 => base_path("controllers/portals/student/index.php"),
    2 => base_path("controllers/portals/tutor/index.php"),
    3 => base_path("controllers/portals/admin/index.php")
];


if (!array_key_exists($_SESSION['permission_level'], $portals)) {
    redirect("/");
}
$portal = $portals[$_SESSION['permission_level']];
require $portal;
