<?php namespace App\Models;

use Maxic\DleAuth\User as DleUser;

class User extends DleUser
{

    protected $connection = 'mysql_dle';
    
    public function services()
    {
        return $this->belongsToMany('App\Models\Service')
            ->withPivot(['price', 'duration'])
            ->withTimestamps();
    }

    public function additionalServices()
    {
        return $this->belongsToMany('App\Models\AdditionalService')
            ->withPivot(['price', 'duration'])
            ->withTimestamps();
    }
}