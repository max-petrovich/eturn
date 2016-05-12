<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @mixin \Eloquent
 */

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['client_name', 'client_phone', 'note'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'visit_start', 'visit_end'];

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

    /**
     * Scopes
     */

    public function scopeDate($query, $date)
    {
        $date = Carbon::parse($date);
        $query->whereDay('visit_start', '=', $date->day);
        $query->whereMonth('visit_start', '=', $date->month);
        $query->whereYear('visit_start', '=', $date->year);

        return $query;
    }

    public function scopeEagerLoadAll($query)
    {
        return $query->with('client', 'master', 'service', 'additionalServices', 'paymentType');
    }

    /**
     * Helpers
     */

    public function getProcedureDuration()
    {
        return Carbon::parse($this->attributes['visit_end'])->diffInMinutes(Carbon::parse($this->attributes['visit_start']));
    }

}
