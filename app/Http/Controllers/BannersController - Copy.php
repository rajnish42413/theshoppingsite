<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\TrandingProducts;
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
		$data['link'] = 'trending-products-add';	
		$results = TrandingProducts::orderBy('id','asc')->get();
		return view('admin.trending_products.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = Banner::select(DB::raw("*"));
		
        if(isset($srch['name']))
        {
            $qry->where('name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'banners.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'banners.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'banners.id';
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
	
    public function add($id=""){ 	
		$data['nav'] = 'menu_banners';
		$data['sub_nav'] = 'menu_banners_add';
		$data['title'] = 'Banner';
		$data['sub_title'] = 'Add';
		$data['link'] = 'banners-list';
		$section_names = DB::table('section_names')->select('*')->orderBy('id','asc')->get();
		$row = array();
		$result = array();
		if($id!=""){
			$result = Banner::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.banners.add',['row'=>$row,'data'=>$data,'section_names'=>$section_names]);
    }	
	
	public function save_data(Request $request){

		$validator = $request->validate([
             'name' => 'required',			 		 		 
             'heading_title' => 'required',			 		 
             'description' => 'required',			 		 
             'section_name' => 'required',	
             'url_link' => 'nullable|url',	
		], 
			$messages = [
			'name.required' => 'Name is required',
			'heading_title.required' => 'Heading Title is required',
			'description.required' => 'Description is required',
			'section_name.required' => 'Section is required',
			'url_link.url' => 'Please enter a valid url',
		]);

		$req   = $request->all();
		$id = $req['id'];
		$pre_fileName   ='';
		if(isset($req['file'])){	
			$file=$request->file('file');
			$name=$file->getClientOriginalName();
			$ext=$file->getClientOriginalExtension();
			$pre_fileName= time().rand().'.'.$ext;
			$file->move('banner_files',$pre_fileName);
		}elseif($req['file_name'] != ''){
			$pre_fileName = $req['file_name'];
		}else{
			$m = json_encode(array('file'=>'Image is required.')); 
			echo ($m."|0");	
			exit;
		}

		$input=array(
			'name'=> $req['name'],
			'description' => addslashes($req['description']),
			'heading_title' => $req['heading_title'],
			'section_name' => $req['section_name'],
			'url_link' => trim($req['url_link']),
			'display_image' => $pre_fileName,
			'updated_by' => Auth::user()->id,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		if($id!=''){
			Banner::on('mysql2')->where('id',$id)->update($input);	
		}else{
			$input['created_by'] = Auth::user()->id;
			$input['created_at'] = date('Y-m-d H:i:s');
			$id = Banner::on('mysql2')->create($input)->id;				
		}	

		echo '|success';				
    }
	
	public function delete_data(Request $request) {
        if ($request->isMethod('post')){
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Banner::on('mysql2')->whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
