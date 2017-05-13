<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accesslevel extends Model
{
    protected $table='accesslevel';
    protected $fillable = [
        'accesslevel',];
    public function users_in_level()
    {
        return $this->hasMany('App\Models\User','accesslevel');
    }
    public $timestamps = false;
}
