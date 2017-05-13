<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobstatus extends Model
{
    protected $table='jobstatus';
    protected $fillable = [
        'status',];
    public $timestamps = false;

}
