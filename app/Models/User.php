<?php namespace App\Models;

use Maxic\DleAuth\User as DleUser;

/**
 * Class User
 * @mixin \Eloquent
 */

class User extends DleUser
{

    protected $fillable = ['email', 'name', 'password', 'fullname'];
    
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

    public function scopeMaster($query)
    {
        return $query->where('user_group', config('dleconfig.roles_user.master'));
    }

    public function scopeAdmin($query)
    {
        return $query->where('user_group', config('dleconfig.roles_user.admin'));
    }

    public function scopeClient($query)
    {
        return $query->where('user_group', config('dleconfig.roles_user.client'));
    }

    public function hasRole($roleName)
    {
        return $this->user_group === getRoleId($roleName);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isMaster()
    {
        return $this->hasRole('master');
    }

    public function isClient()
    {
        return $this->hasRole('client');
    }
}