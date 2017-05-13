<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobfinish extends Model
{
    protected $table='jobfinish';
    protected $fillable = [
        'jobid','oct',
        'nch','nct','ncp',
        'sch','sct','scp',
        'ach','act','acp',
    ];
}
