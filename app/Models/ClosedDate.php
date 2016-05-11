<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClosedDate
 * @mixin \Eloquent
 */

class ClosedDate extends Model
{
    protected $primaryKey = 'closed_date';

    public $incrementing = false;

    protected $dates = ['created_at', 'updated_at', 'closed_date'];
}
