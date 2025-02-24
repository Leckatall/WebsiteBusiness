<?php

namespace Core;

class Session
{
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public static function get($key, $default = null)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }
    public static function flash($key, $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }
    public static function clearFlash()
    {
        unset($_SESSION['_flash']);
    }
}