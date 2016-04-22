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
    
    public function __construct()
    {
        parent::__construct();
        $this->table = config('dleconfig.prefix') . '_users';
    }

    public function isAdmin()
    {
        return in_array($this->user_group, (array)config('dleconfig.roles_user.admin'));
    }

    public function isMaster()
    {
        return in_array($this->user_group, (array)config('dleconfig.roles_user.master'));
    }

    public function isClient()
    {
        return !$this->isMaster();
    }

}