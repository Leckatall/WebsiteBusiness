<?php


function isActivePage($page){
    return $page == $_SERVER['REQUEST_URI'];
}
