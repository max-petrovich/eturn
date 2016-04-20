<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Models\User')
            ->withPivot(['price', 'duration'])
            ->withTimestamps();
    }

    public function additionalServices()
    {
        return $this->hasMany('App\Models\AdditionalService');
    }
}
