<?php namespace App\Entities;

class Weekdays
{

    public static function getAbbr()
    {
        return [
            0 => 'Sun',
            1 => 'Mon',
            2 => 'Tue',
            3 => 'Wed',
            4 => 'Thu',
            5 => 'Fri',
            6 => 'Sat'
        ];
    }

    public static function getFullNames()
    {
        return [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday'
        ];
    }

    public static function getFullNameByName($name)
    {
        $names = collect(static::getFullNames());
        return $names->flip()->get($name);
    }

    public static function getFullNameById($id)
    {
        $names = collect(static::getFullNames());
        return $names->get($id);
    }

    public static function getNameById($id)
    {
        $names = collect(static::getAbbr());
        return $names->get($id);
    }

}