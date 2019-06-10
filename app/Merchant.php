<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
   // public $timestamps = false;
   // protected $guarded = [];
   protected $table = "merchants";
    protected $fillable = ['name', 'slug', 'image', 'status'];	

}
