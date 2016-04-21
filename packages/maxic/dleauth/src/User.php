<?php namespace Maxic\DleAuth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'dle_users';

    protected $primaryKey = 'user_id';
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
}