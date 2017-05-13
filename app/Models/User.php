<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Accesslevel;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'email', 'password','address','accesslevel','title','mobile','phone',
        'fax','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role()
    {
        return $this->belongsTo('App\Models\Accesslevel','accesslevel');
    }
    public function user_title()
    {
        return $this->belongsTo('App\Models\title','title');
    }
    public function user_sites()
    {
        return $this->hasMany('App\Models\Site','supervisor');
    }

}
