<?php namespace Maxic\DleAuth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

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


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('dleconfig.db_prefix') . 'users';
//        $this->connection = config('dleconfig.db_connection_name');
    }

    public function getIdAttribute()
    {
        return $this->attributes['user_id'];
    }

}