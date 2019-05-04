<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Category;
use App\Product;
use Mail;

class ProductsController extends Controller
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
		$data['nav'] = 'menu_products';
		$data['sub_nav'] = 'menu_products_list';
		$data['title'] = 'Products';
		$data['sub_title'] = 'List';
		$data['link'] = 'products-add';
		$categories = Category::where('parentId',0)->orderBy('id','asc')->get();
		return view('admin.products.list',['categories'=>$categories,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){

        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
	
		
        if(isset($srch['title']))
        {
            $qry->where('products.title','like',"%" .$srch['title']. "%");
        }
        if(isset($srch['categoryName']))
        {
            $qry->where('products.categoryId',$srch['categoryName']);
        }else{
		}		
        if(isset($srch['parentCategoryName']))
        {
            $qry->where('categories.parentId',$srch['parentCategoryName']);
        }
		
		
        
		if($order[0] == 'list_create'){
			$order[0] = 'products.created_at';
		}
		else if($order[0] == 'listId'){
			$order[0] = 'products.id';
		}
		else if($order[0] == 'id'){
			$order[0] = 'products.id';
		}					
	
		$qry->orderByRaw("$order[0] $order[1]");	
		 
        $data['results'] = [];
        $results = $qry->paginate($length);
        
        foreach($results as $rec){
            $data['results'][] = $rec;
        }
		//echo '<Pre>';print_r($data['results']);die;
        $total = count($data['results']);
        return $this->responseDTJson($req->draw,$results->total(), $results->total(), $data['results']);    
    }
	
    public function add($id="")
    { 
		$data['nav'] = 'menu_products';
		$data['sub_nav'] = 'menu_products_add';
		$data['title'] = 'Product';
		$data['sub_title'] = 'Add';
		$data['link'] = 'products-list';
		$categories = array();
		$categories = Category::get();
		$row = array();
		$result = array();
		if($id!=""){
			$result = Product::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.products.add',['row'=>$row,'data'=>$data,'categories'=>$categories]);
    }	
	
	public function save_data(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 
             'categoryId' => 'required',			 		 		 		 		 
			], 
			$messages = [
			'name.required' => 'Name is required',
			'categoryId.required' => 'Category is required',
		])->validate();	

        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			
			$req   = $request->all();
			$id = $req['id'];

			$input=array(
				'name'=> $req['name'],
				'categoryId' => $req['categoryId'],
			);
			if($id!=''){
				Product::where('id',$id)->update($input);	
			}else{
				$id = Product::create($input)->id;				
			}	

			echo "|success";
		
		}
    }
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Product::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
