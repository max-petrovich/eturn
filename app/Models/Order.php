<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function client()
    {
        return $this->belongsTo('App\Models\User', 'client_user_id');
    }

    public function master()
    {
        return $this->belongsTo('App\Models\User','master_user_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function paymentType()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }
}
