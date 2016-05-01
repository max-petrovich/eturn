<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @mixin \Eloquent
 */

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['client_name', 'client_phone'];

    protected $dates = ['deleted_at'];

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

    public function additionalServices()
    {
        return $this->belongsToMany('App\Models\AdditionalService')
            ->withTimestamps();
    }

    public function paymentType()
    {
        return $this->belongsTo('App\Models\PaymentType');
    }

    public function canceled()
    {
        return $this->hasOne('App\Models\CanceledOrder');
    }

    public function hiddenUser()
    {
        return $this->hasMany('App\Models\OrderHiddenUser');
    }

}
