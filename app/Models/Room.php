<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table='room';
    protected $fillable = [
        'identifierFD', 'site','type'];
    public function site()
    {
        return $this->belongsTo('App\Models\Site','site');
    }
    public $timestamps = false;
}
