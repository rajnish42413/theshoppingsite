<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\TrandingProducts;
use App\Category;
use Mail;



class TrendingProductsController extends Controller
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
		$data['nav'] = 'menu_trending_products';
		$data['sub_nav'] = 'menu_trending_products_list';
		$data['title'] = 'Trending Products';
		$data['sub_title'] = 'List';
		$data['link'] = 'trending_products-add';	
		$results = TrandingProducts::orderBy('id','asc')->get();
		//print_r($results);
		return view('admin.trending_products.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
       
		$qry = TrandingProducts::select(DB::raw("tranding_products.*,categories.categoryName"))->leftJoin('categories',function ($join){$join->on('categories.categoryId','=','tranding_products.category_id'); });
        if(isset($srch['title']))
        {
            $qry->where('title','like',"%" .$srch['title']. "%");
           
        }
       
				if($order[0] == 'list_create'){
					$order[0] = 'tranding_products.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'tranding_products.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'tranding_products.id';
				}					
			
				$qry->orderByRaw("$order[0] $order[1]");	
		//echo $qry->toSql();die;
        $data['results'] = [];
        $results = $qry->paginate($length);
        
        foreach($results as $rec){
            $data['results'][] = $rec;
        }
        $total = count($data['results']);
        return $this->responseDTJson($req->draw,$results->total(), $results->total(), $data['results']);    
    }
	
    public function add($id=""){ 	
		$data['nav'] = 'menu_trending_products';
		$data['sub_nav'] = 'menu_trending_products_add';
		$data['title'] = 'Trending Products';
		$data['sub_title'] = 'Add';
		$data['link'] = 'trending-products-list';
		$find = array(184972,112529,93427,15724,3034,159912,178893,48638);
		$categories = Category::orderBy('id','asc')->whereIn('categoryId', $find)->get();
		//echo $categories->toSql();die;
		
		$row = array();
		$result = array();
		if($id!=""){
			$result = TrandingProducts::where('id',$id)->first();
			if($result){
				$row = $result;
				//echo '<pre>';print_R();die;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.trending_products.add',['row'=>$row,'data'=>$data,'categories'=>$categories]);
    }	
	
	public function save_data(Request $request){ 

		$validator = $request->validate([
             'pro_title' => 'required',			 		 		 
             'category' => 'required',	
             'merchant_name1'=>	'required',		 		 
             'merchant_name2'=>	'required',		 		 
             'merchant_name3'=>	'required',		 		 
             'merchant_price1'=>'required',		 		 
             'merchant_price2'=>'required',		 		 
             'merchant_price3'=>'required',		 		 
             'merchant_link1' => 'required|url',	
             'merchant_link2' => 'required|url',	
             'merchant_link3' => 'required|url',	
             'description' => 'required',	
             
		], 
		 
		
			$messages = [
			'pro_title.required' => 'Title is required',
			'category.required' => 'Category is required',
			'merchant_name1.required' => 'Merchant name is required',
			'merchant_name2.required' => 'Merchant name is required',
			'merchant_name3.required' => 'Merchant name is required',
			'merchant_price1.required' => 'Product price is required',
			'merchant_price2.required' => 'Product price is required',
			'merchant_price3.required' => 'Product price is required',
			'merchant_link1.url' => 'Please enter a valid url',
			'merchant_link2.url' => 'Please enter a valid url',
			'merchant_link3.url' => 'Please enter a valid url',
			'description.required' => 'Description is required',
			
		]);

		$req   = $request->all();
		$id = $req['id'];
		$pre_fileName   ='';
		if(isset($req['file'])){	
			$file=$request->file('file');
			$name=$file->getClientOriginalName();
			$ext=$file->getClientOriginalExtension();
			$pre_fileName= time().rand().'.'.$ext;
			$file->move('trending_products_files',$pre_fileName);
		}elseif($req['file_name'] != ''){
			$pre_fileName = $req['file_name'];
		}else{
			$m = json_encode(array('file'=>'Image is required.')); 
			echo ($m."|0");	
			exit;
		}
		if($req['pro_title']){
			$slug = $this->slugify($req['pro_title']); 
		}else{
			$slug = '';
		}
		

		$input=array(
			'title'=> $req['pro_title'],
			'slug'=> $slug,
			'category_id'=> $req['category'],
			'description' => ($req['description']),
			'merchant1' => trim($req['merchant_name1']),
			'merchant2' => trim($req['merchant_name2']),
			'merchant3' => trim($req['merchant_name3']),
			'price1' => trim($req['merchant_price1']),
			'price2' => trim($req['merchant_price2']),
			'price3' => trim($req['merchant_price3']),
			'link1' => trim($req['merchant_link1']),
			'link2' => trim($req['merchant_link2']),
			'link3' => trim($req['merchant_link3']),
			'image' => $pre_fileName,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		if($id!=''){
//echo $id;die;
			TrandingProducts::where('id',$id)->update($input);	
		}else{

			$input['created_at'] = date('Y-m-d H:i:s');
			$input['created_at'] = date('Y-m-d H:i:s');
			
			 //TrandingProducts::create($input);
			DB::table('tranding_products')->insert($input);	
					
		}	
		//echo $categories->toSql();die;
		echo '|success';				
    }
	
	
	private function slugify($text)
		{
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
	
	public function delete_data(Request $request) {
        if ($request->isMethod('post')){
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			TrandingProducts::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }

    public function get_category_by_parent(Request $request){
		$output = '';
		$req    = $request->all();
		$parent_id = $req['parent_id'];
		$categories = Category::where('parentId',$parent_id)->where('status',1)->get();
		if($categories){
				$output .=  '<option value="">--Select sub-Category--</option>';
			foreach($categories as $state){
					$output .=  '<option value="'.$state->categoryId.'"  >'.$state->categoryName.'</option>';	
			}
		}else{
			$output .= '<option value="">--Select sub-Category--</option>';
		}
		echo $output;		
	}	
	
}
