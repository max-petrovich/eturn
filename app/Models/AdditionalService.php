<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{

    public function users()
    {
        return $this->belongsToMany('App\Models\User')
            ->withPivot(['price', 'duration'])
            ->withTimestamps();
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function order()
    {
        return $this->belongsToMany('App\Models\Order')
            ->withTimestamps();
    }
}
