<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function districts()
    {
        return $this->hasMany('App\District');
    }
	
    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
