<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{

    protected $table = 'user_data';

    public $primaryKey = 'user_id';

    protected $fillable = [
        'minimum_service_duration',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
