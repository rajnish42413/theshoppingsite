<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    protected $table = "navigation_menu";
    
    protected $fillable = [
        'id','name','parent_id','slug','link_name','has_child','is_child','is_public','status','created_at','updated_at','created_by','updated_by'
    ];
	
	
}
