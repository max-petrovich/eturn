<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
    use HasRoleAndPermission;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function data()
    {
        return $this->hasMany('App\Models\UserData');
    }

    public function services()
    {
        return $this->belongsToMany('App\Models\Service')
            ->withPivot(['price', 'duration'])
            ->withTimestamps();
    }

    public function additionalServices()
    {
        return $this->belongsToMany('App\Models\AdditionalService')
            ->withPivot(['price', 'duration'])
            ->withTimestamps();
    }

    public function orders()
    {
        $this->hasMany('App\Models\Order');
    }

    public function schedule()
    {
        return $this->hasMany('App\Models\UserSchedule');
    }

    public function scheduleException()
    {
        return $this->hasMany('App\Models\UserScheduleException');
    }

    public function hiddenOrders()
    {
        return $this->hasMany('App\Models\UserHiddenOrder');
    }

    /**
     * Scopes
     */

    /**
     * Scope a query select user by role Id
     * @param $role int|string
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole(EloquentBuilder $query, $role)
    {
        return $query->whereHas('roles', function (EloquentBuilder $q) use($role) {
            if (is_string($role)) {
                $q->whereSlug($role);
            } else {
                $q->whereRoleId($role);
            }
        });
    }

    /**
     * @param $key string
     * @return string|int
     */
    public function getData($key)
    {
        return $this->data()->whereKey($key)->first()->value;
    }

    /**
     * Accessors & Mutators
     */

    public function getFioAttribute()
    {
        return $this->attributes['name'];
    }

    public function setFioAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
    
}
