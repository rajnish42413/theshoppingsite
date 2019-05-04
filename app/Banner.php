<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = "banner";
    
    protected $fillable = [
        'id','name','heading_title','display_image','description','header_banner','status','created_at','updated_at','created_by','updated_by'
    ];
	
	
}
