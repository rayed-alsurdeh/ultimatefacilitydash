<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobService extends Model
{
    protected $table='jobservice';
    protected $fillable = ['jobid', 'gtype','type','room', 'rmst','rend','note','numofrooms',''];
    public function service_job()
    {
        return $this->belongsTo('App\Models\Job','jobid');
    }
    public function room_id()
    {
        return $this->belongsTo('App\Models\Room','room');
    }
    public function rmst_id()
    {
        return $this->belongsTo('App\Models\Room','rmst');
    }
    public function rend_id()
    {
        return $this->belongsTo('App\Models\Room','rend');
    }
    public function service_name()
    {
        return $this->belongsTo('App\Models\Service','type');
    }

    public $timestamps = false;
}
