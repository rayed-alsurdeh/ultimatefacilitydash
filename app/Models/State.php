<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table='state';
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;
}
