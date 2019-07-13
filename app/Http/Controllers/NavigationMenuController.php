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
use Mail;



class NavigationMenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
		$data['nav'] = 'menu_navigation_menu';
		$data['sub_nav'] = 'menu_navigation_menu_list';
		$data['title'] = 'Navigation Menu';
		$data['sub_title'] = 'List';
		$data['link'] = 'navigation-menu-add';
		$results = NavigationMenu::orderBy('id','asc')->get();
		return view('admin.navigation_menu.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = NavigationMenu::select(DB::raw("navigation_menu.*, b.name as parent_name"))->leftJoin('navigation_menu AS b',function ($join){$join->on('navigation_menu.parent_id','=','b.id'); })->orderBy('navigation_menu.id','asc');
		
        if(isset($srch['name']))
        {
            $qry->where('name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'navigation_menu.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'navigation_menu.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'navigation_menu.id';
				}					
			
				$qry->orderByRaw("$order[0] $order[1]");	
		 
        $data['results'] = [];
        $results = $qry->paginate($length);
        
        foreach($results as $rec){
            $data['results'][] = $rec;
        }
        $total = count($data['results']);
        return $this->responseDTJson($req->draw,$results->total(), $results->total(), $data['results']);    
    }
	
    public function add($id="")
    { 
		$data['nav'] = 'menu_navigation_menu';
		$data['sub_nav'] = 'menu_navigation_menu_add';
		$data['title'] = 'Navigation Menu';
		$data['sub_title'] = 'Add';
		$data['link'] = 'navigation-menu-list';
		$parents = NavigationMenu::orderBy('id','asc')->get();		
		$row = array();
		$result = array();
		if($id!=""){
			$result = NavigationMenu::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.navigation_menu.add',['row'=>$row,'data'=>$data,'parents'=>$parents]);
    }	
	
	public function save_data(Request $request){
		
		$validator = $request->validate([
             'name' => 'required',			 		 		 
             'parent_id' => 'required',			 		 
             'link_name' => 'required',			 		  		 
			], 
			$messages = [
			'name.required' => 'Name is required',
			'parent_id.required' => 'Parent is required',
			'link_name.required' => 'Link is required',
		]);		

		$req   = $request->all();
		$id = $req['id'];
		$parent_id = $req['parent_id'];
		$name = trim($req['name']);
		$link_name = trim($req['link_name']);
		$is_public = trim($req['is_public']);
		$has_child = 0;
		$is_child = 0;
		if($parent_id != 0){
			$is_child = 1;
		}
		$slug = $this->slugify($name);
		$input=array(
			'name'=> $name,
			'parent_id' => $parent_id,
			'slug' => $slug,
			'has_child' => $has_child,
			'is_child' => $is_child,
			'is_public' => $is_public,
			'link_name' => $link_name,
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		if($id!=''){
			NavigationMenu::on('mysql2')->where('id',$id)->update($input);	
		}else{
			$input['created_by'] = Auth::user()->id;
			$input['created_at'] = date('Y-m-d H:i:s');
			$id = NavigationMenu::on('mysql2')->create($input)->id;				
		}	
		if($parent_id != 0){
			$check = NavigationMenu::where('id',$parent_id)->first();
			if($check->count()>0){
				$input2['slug'] = "#";
				$input2['has_child'] = 1;
				NavigationMenu::on('mysql2')->where('id',$check->id)->update($input2);
			}
		}
		echo '|success';				

    }
	
	public function delete_data(Request $request) {

        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			NavigationMenu::on('mysql2')->whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	static public function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'utf-8//TRANSLIT', $text);

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
}
