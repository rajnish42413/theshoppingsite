<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\MapCategory;
use App\Category;
use App\Merchant;
use Mail;



class MapCategoriesController extends Controller
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
		$data['nav'] = 'menu_map_categories';
		$data['sub_nav'] = 'menu_map_categories_list';
		$data['title'] = 'Map Category';
		$data['sub_title'] = 'List';
		$data['link'] = 'map-categories-add';
		$results = MapCategory::orderBy('id','asc')->get();
		return view('admin.map_categories.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = MapCategory::select(DB::raw("map_categories.*, b.name as parent_name"))->leftJoin('map_categories AS b',function ($join){$join->on('map_categories.parent_id','=','b.id'); })->orderBy('map_categories.id','asc');
		
        if(isset($srch['name']))
        {
            $qry->where('name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'map_categories.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'map_categories.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'map_categories.id';
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
		$data['nav'] = 'menu_map_categories';
		$data['sub_nav'] = 'menu_map_categories_add';
		$data['title'] = 'Map Category';
		$data['sub_title'] = 'Add';
		$data['link'] = 'map-categories-list';
		$parents = MapCategory::orderBy('id','asc')->get();		
		$merchants = Merchant::where('status',1)->orderBy('id','asc')->get();		
		$row = array();
		$result = array();
		if($id!=""){
			$result = MapCategory::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.map_categories.add',['row'=>$row,'data'=>$data,'parents'=>$parents,'merchants'=>$merchants]);
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
			MapCategory::where('id',$id)->update($input);	
		}else{
			$input['created_by'] = Auth::user()->id;
			$input['created_at'] = date('Y-m-d H:i:s');
			$id = MapCategory::create($input)->id;				
		}	
		if($parent_id != 0){
			$check = MapCategory::where('id',$parent_id)->first();
			if($check->count()>0){
				$input2['slug'] = "#";
				$input2['has_child'] = 1;
				MapCategory::where('id',$check->id)->update($input2);
			}
		}
		echo '|success';				

    }
	
	public function delete_data(Request $request) {

        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			MapCategory::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
	public function get_category_by_merchant(Request $request){
		
		if($request->isMethod('post')){
			
			if(trim($request->input('keyword')) != '' && $request->input('merchant_id')){
				
				$keyword = trim($request->input('keyword'));
				$merchant_id = trim($request->input('merchant_id'));
				
				$results = Category::select(DB::raw('*'))->where('merchant_id',$merchant_id)->where('categories.status',1)->where('categories.categoryName','like',"%$keyword%")->get(); 
				
				if($results && $results->count() > 0){
					return view('admin.map_categories.get_categories',['results'=>$results,'merchant_id'=>$merchant_id])->render();
				}
				
			}
		}
	}
}
