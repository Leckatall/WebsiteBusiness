<?php


function isActivePage($page){
    return $page == $_SERVER['REQUEST_URI'];
}

function dd($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    die();
}

function base_path($path){
    return BASE_PATH . $path;
}
function load_partial($path, $attributes=[]){
    extract($attributes);
    require base_path('views/partials/'. $path);
}
function load_view($path, $attributes = []){
    extract($attributes);
    load_partial('header.php');
    load_partial('nav.php');
    load_partial('banner.php', ['heading' => $heading]);
    require base_path('views/'. $path);
    load_partial('footer.php');
}
function get_image_src($path): string{
    return "/src/images/{$path}";
}
function redirect($path){
    header("Location: {$path}");
    exit();
}







