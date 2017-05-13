<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class title extends Model
{
    protected $table='titles';
    protected $fillable = [
        'title'
    ];
    public function title_users()
    {
        return $this->hasMany('App\Models\User','title');
    }
    public $timestamps = false;
}
