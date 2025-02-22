<?php

use Core\App;
use Core\Container;
use Core\Database\AccountManager;
use Core\Database\Database;


$container = new Container();

$container->bind('Core\\Database\\Database', function (){
    $config = require base_path('config.php');
    return new Database($config['database']);
});

$container->bind('Core\Database\AccountManager', function (){
    $config = require base_path('config.php');
    return new AccountManager();
});

App::setContainer($container);

