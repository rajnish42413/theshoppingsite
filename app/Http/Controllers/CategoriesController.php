<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Category;
use Mail;

class CategoriesController extends Controller
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
		$data['nav'] = 'menu_categories';
		$data['sub_nav'] = 'menu_categories_list';
		$data['title'] = 'Categories';
		$data['sub_title'] = 'List';
		$data['link'] = 'categories-add';
		$categories = Category::where('parentId',0)->orderBy('id','asc')->get();
		return view('admin.categories.list',['categories'=>$categories,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){

        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = Category::select(DB::raw("categories.*, c2.categoryName as parentCategoryName"))->Join('categories AS c2',function ($join){$join->on('categories.parentId','=','c2.categoryId'); });
		$qry->where('categories.parentId','!=','0');
        if(isset($srch['categoryName']))
        {
            $qry->where('categories.categoryName','like',"%" .$srch['categoryName']. "%");
        }
		
        if(isset($srch['parentCategoryName']))
        {
            $qry->where('categories.parentId',$srch['parentCategoryName']);
        }		
        
		if($order[0] == 'list_create'){
			$order[0] = 'categories.created_at';
		}
		else if($order[0] == 'listId'){
			$order[0] = 'categories.id';
		}
		else if($order[0] == 'id'){
			$order[0] = 'categories.id';
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
		$data['nav'] = 'menu_categories';
		$data['sub_nav'] = 'menu_categories_add';
		$data['title'] = 'Category';
		$data['sub_title'] = 'Add';
		$data['link'] = 'categories-list';
		$row = array();
		$result = array();
		if($id!=""){
			$result = Category::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.categories.add',['row'=>$row,'data'=>$data]);
    }	
	
	public function save_data(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 
             'sortname' => 'required',			 	 		 		 		 
			], 
			$messages = [
			'name.required' => 'Name is required',
			'sortname.required' => 'Sortname is required',
		])->validate();	

        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			
			$req   = $request->all();
			$id = $req['id'];

			$input=array(
				'name'=> $req['name'],
				'sortname' => $req['sortname'],
			);
			if($id!=''){
				Category::where('id',$id)->update($input);	
			}else{
				$id = Category::create($input)->id;				
			}	

			echo "|success";
		
		}
    }
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Category::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
	public function get_category_by_parent(Request $request){
		$output = '';
		$req    = $request->all();
		$parent_id = $req['parent_id'];
		$categories = Category::where('parentId',$parent_id)->get();
		if($categories){
				$output .=  '<option value="">--Select Category--</option>';
			foreach($categories as $state){
					$output .=  '<option value="'.$state->categoryId.'"  >'.$state->categoryName.'</option>';	
			}
		}else{
			$output .= '<option value="">--Select Category--</option>';
		}
		echo $output;		
	}
	
}
