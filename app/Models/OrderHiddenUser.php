<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderHiddenUser
 * @mixin \Eloquent
 */
class OrderHiddenUser extends Model
{

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
