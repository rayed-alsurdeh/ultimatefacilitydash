<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table='site';
    protected $fillable = [
        'name', 'description', 'state','city','suburb','address','mobile','clnCostPH','supervisor',
        'site_owner'
    ];
    public function site_rooms()
    {
        return $this->hasMany('App\Models\Room','site');
    }
    public function site_state()
    {
        return $this->belongsTo('App\Models\State','state');
    }
    public function site_sup()
    {
        return $this->belongsTo('App\Models\User','supervisor');
    }
    public function owner()
    {
        return $this->belongsTo('App\Models\User','site_owner');
    }
    public function site_jobs()
    {
        return $this->hasMany('App\Models\Job','siteid');
    }
    public $timestamps = true;
}
