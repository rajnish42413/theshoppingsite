<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //public $timestamps = false;
    //protected $guarded = [];
	protected $table = "categories";
    protected $fillable = [
        'id','categoryId','parentId','slug','catLevel','categoryName','nav_menu_id','is_top_category','image','status','created_at','updated_at'
    ];	

}
