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

    public static function destroy()
    {
        session_destroy();
    }

    public static function login(int $userId, int $privilege_level): void
    {
        session_regenerate_id(true);
        var_dump($_SESSION['user']);
        $_SESSION['user']['id'] = $userId;
        $_SESSION['user']['privilege_level'] = $privilege_level;
        $_SESSION['logged_in'] = true;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        session_start();
        session_regenerate_id(true);
        $_SESSION['logged_in'] = false;
    }

    public static function getRole(): int
    {
        return $_SESSION['user']['privilege_level'] ?? 0;
    }
    public static function getId(): int
    {
        return $_SESSION['user']['id'] ?? -1;
    }
}