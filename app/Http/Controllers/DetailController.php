<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\NavigationMenu;
use App\Category;
use App\SocialSetting;
use App\Setting;
use Mail;



class DetailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	public static function get_settings(){
		$row = Setting::limit(1)->first();
		if($row && $row->count() > 0){
			return $row;
		}else{
			return false;
		}
	}
	
	
	public static function get_social_links(){
		$row = SocialSetting::where('status',1)->get();
		return $row;
	}
	
	static public function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
		return 'n-a';
	  }

	  return $text;
	}
	
	public static function get_nav_menus($parent_id=""){
		$nav_menus = array();
		if($parent_id == ""){
			$parent_id = '0';
		}
		$results = Category::orderBy('id','asc');
		if($parent_id!= '0'){
			$results = $results->where('parentId',$parent_id);
		}		
		$results = $results->get();
		if($results->count() > 0){
			$nav_menus = $results;
		}
		return $nav_menus;
	}
	
	public static function get_main_nav_menus(){
		$nav_menus = array();
		
		$results = NavigationMenu::where('status',1)->orderBy('id','asc')->get();
		if($results && $results->count() > 0){
			$i=0;
			foreach($results as $row){
				$nav_menus[$i]['nav_menu_name'] = $row->name; //string
				$nav_menus[$i]['categories'] = array(); //array
				
				$menu_id = $row->id;
				$categories = Category::where('nav_menu_id',$menu_id)->where('parentId',0)->where('status',1)->orderBy('id','asc')->get();
				if($categories && $categories->count() > 0){
					$j=0;
					foreach($categories as $cat){
						$parentId = $cat->categoryId;
						$nav_menus[$i]['categories'][$j]['id'] = $parentId; //string
						$nav_menus[$i]['categories'][$j]['name'] = $cat->categoryName;//string
						$nav_menus[$i]['categories'][$j]['slug'] = $cat->slug; //string
						$nav_menus[$i]['categories'][$j]['sub_categories'] = array();//array
						$nav_menus[$i]['categories'][$j]['sub_cat_count'] = 0; //string
						$sub_categories = Category::where('parentId',$parentId)->where('status',1)->orderBy('id','asc')->get();
						if($sub_categories && $sub_categories->count() > 0){
							$k=0;
							foreach($sub_categories as $sub){
								$nav_menus[$i]['categories'][$j]['sub_categories'][$k]['id'] = $sub->categoryId; //string
								$nav_menus[$i]['categories'][$j]['sub_categories'][$k]['name'] = $sub->categoryName; //string
								$nav_menus[$i]['categories'][$j]['sub_categories'][$k]['slug'] = $sub->slug; //string
								
								$k++;
								
							}
							$nav_menus[$i]['categories'][$j]['sub_cat_count'] = $k;
						}
						$j++;
						
					}
					
				}
				$i++;
			}
		}
		//echo '<pre>'; print_r($nav_menus); die;
		return $nav_menus;
	}

	public static function get_menu_permissions(){
		$menu_permissions = array();
		$user = User::where('id',Auth::user()->id)->first();
		if($user && $user->count() > 0){
			if($user->menu_permissions!=''){
				$menu_permissions = explode(',',$user->menu_permissions);
			}
		}
		return $menu_permissions;
	}
	
	public static function getStringBold($arr,$string){
		if($arr){
			$string = strtolower($string);
			foreach($arr as $key) {
				if(strpos($string,$key) !== FALSE) { 
					$new_key  = '<b>'.ucwords($key).'</b>';
					$string = str_replace($key, $new_key, $string);
				}
			}			
		}
		return $string;		
	}
}
