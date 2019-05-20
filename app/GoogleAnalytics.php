<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleAnalytics extends Model
{
    protected $table = "google_analytics";
    
    protected $fillable = [
        'id','content','status','created_at','updated_at'
    ];
	
	
}
