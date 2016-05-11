<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSchedule
 * @mixin \Eloquent
 */

class UserSchedule extends Model
{
    protected $dates = ['created_at', 'updated_at', 'closed_date'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeWeekday($query, $day)
    {
        return $query->whereWeekday($day);
    }
}
