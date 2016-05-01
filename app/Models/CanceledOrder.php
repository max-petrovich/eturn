<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CanceledOrder
 * @mixin \Eloquent
 */

class CanceledOrder extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
