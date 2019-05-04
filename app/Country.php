<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function states()
    {
        return $this->hasMany('App\State');
    }
	
    public function districts()
    {
        return $this->hasMany('App\District');
    }
	
    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
