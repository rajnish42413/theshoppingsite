<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = "currencies";
    
    protected $fillable = [
        'id','name','description','exchange_rate','status','created_at','updated_at'
    ];
}
