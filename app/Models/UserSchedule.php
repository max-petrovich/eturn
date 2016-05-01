<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSchedule
 * @mixin \Eloquent
 */

class UserSchedule extends Model
{

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
