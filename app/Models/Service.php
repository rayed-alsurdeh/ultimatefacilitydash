<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table='service';
    protected $fillable = [
        'service'];
    public $timestamps = false;
}