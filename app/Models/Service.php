<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * @mixin \Eloquent
 */

class Service extends Model
{

    protected $fillable = ['title', 'description'];

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
