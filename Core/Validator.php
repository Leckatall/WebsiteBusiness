<?php

namespace Core;

class Validator
{
    public static function validateEmail($email){

    }
    public static function validatePassword($password){

    }

    public static function validateString($string, $minlen = 1, $maxlen = INF){
        $string = trim($string);
        return strlen($string) > $minlen && strlen($string) < $maxlen;
    }
}