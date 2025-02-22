<?php

namespace Core;

class Validator
{
    public static function registration_errors($email, $password): array
    {
        $errors = [];
        $email_errs = static::email_errors($email);
        if($email_errs){
            $errors['email'] = $email_errs;
        }
        $password_errs = static::password_errors($password);
        if($password_errs){
            $errors['password'] = $password_errs;
        }
        return $errors;
    }
    public static function email_errors($email): string
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "Invalid email";
        }
        return "";
    }
    public static function password_errors($password): string
    {
        // TODO: Add more password validation
        if (strlen($password) < 8){
            return "Password must be at least 8 characters";
        }
        return "";
    }

    public static function validateString($string, $minlen = 1, $maxlen = INF){
        $string = trim($string);
        return strlen($string) > $minlen && strlen($string) < $maxlen;
    }
}