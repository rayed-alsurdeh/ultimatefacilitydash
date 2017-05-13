<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobService;
use App\Models\Jobfinish;

class Job extends Model
{
    protected $table='job';
    protected $fillable = [
        'vac_date', 'jobnote','siteid','numofrooms','status','jc','finished_at'];
    public function job_services()
    {
        return $this->hasMany('App\Models\JobService','jobid');
    }
    public function job_status()
    {
        return $this->belongsTo('App\Models\Jobstatus','status');
    }
    public function job_comment()
    {
        return $this->hasMany('App\Models\Jobcomment','job');
    }
    public function job_site()
    {
        return $this->belongsTo('App\Models\Site','siteid');
    }
    public function job_c()
    {
        return $this->belongsTo('App\Models\User','jc');
    }
    public function job_cost_record()
    {
        return $this->hasOne('App\Models\Jobfinish','jobid');
    }

 }
