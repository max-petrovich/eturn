<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiddenOrderMonitoring extends Model
{
    protected $table = 'hidden_order_monitoring';

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
