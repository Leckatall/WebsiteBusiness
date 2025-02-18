<?php

namespace Core;

class App
{
    protected static $container;

    public static function setContainer($container){
        static::$container = $container;
    }
    public static function getContainer(){
        return static::$container;
    }
    public static function bind($key, $func)
    {
        static::$container->bind($key,$func);
    }
    public static function run($key){
        return static::$container->run($key);
    }

}