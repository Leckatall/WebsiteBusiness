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