<?php namespace Maxic\DleAuth;

class DleCrypt
{

    public static function crypt($value)
    {
        return md5(md5($value));
    }

    public static function check($value, $hashedValue)
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return static::crypt($value) == $hashedValue;
    }
}