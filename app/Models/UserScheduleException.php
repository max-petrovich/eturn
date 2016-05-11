<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserScheduleException
 * @mixin \Eloquent
 */

class UserScheduleException extends Model
{
    protected $dates = ['created_at', 'updated_at', 'exception_date'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeDate($query, $date)
    {
        return $query->whereExceptionDate($date);
    }
}
