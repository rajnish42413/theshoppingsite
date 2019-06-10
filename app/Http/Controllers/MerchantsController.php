<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Merchant;
use Mail;



class MerchantsController extends Controller
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
		$data['nav'] = 'menu_merchants';
		$data['sub_nav'] = 'menu_merchants_list';
		$data['title'] = 'Merchants';
		$data['sub_title'] = 'List';
		$data['link'] = 'merchants-add';
		$results = Merchant::orderBy('id','asc')->get();
		return view('admin.merchants.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = Merchant::select(DB::raw("merchants.*"))->orderBy('merchants.id','asc');
		
        if(isset($srch['name']))
        {
            $qry->where('name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'merchants.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'merchants.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'merchants.id';
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
		$data['nav'] = 'menu_merchants';
		$data['sub_nav'] = 'menu_merchants_add';
		$data['title'] = 'Merchants';
		$data['sub_title'] = 'Add';
		$data['link'] = 'merchants-list';
		$parents = Merchant::orderBy('id','asc')->get();		
		$row = array();
		$result = array();
		if($id!=""){
			$result = Merchant::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.merchants.add',['row'=>$row,'data'=>$data,'parents'=>$parents]);
    }	
	
	public function save_data(Request $request){
		$req   = $request->all();
		$id = $req['id'];
		$is_unique = '|unique:merchants';
		$merchant_name = trim($req['name']);	
 		$merchant_check = Merchant::where('id',$id)->first();
		
		if($merchant_check && $merchant_check->count() > 0){
			if(strtolower($merchant_check->name) == strtolower($merchant_name)){
				$is_unique = '';
			}
		} 
		
		$validator = $request->validate([
             'name' => 'required'.$is_unique,			 		 		 		 		  		 
			], 
			$messages = [
			'name.required' => 'Name is required',
		]);		
		$slug = $this->slugify($merchant_name);
		$pre_fileName   ='';
		if(isset($req['file'])){	
			$file=$request->file('file');
			$name=$file->getClientOriginalName();
			$ext=$file->getClientOriginalExtension();
			$pre_fileName= $slug.'.'.$ext;
			$file->move('merchant_files',$pre_fileName);
		}elseif($req['file_name'] != ''){
			$pre_fileName = $req['file_name'];
		}else{
			$m = json_encode(array('file'=>'Image is required.')); 
			echo ($m."|0");	
			exit;
		}		

		
		$input= array(
			'name'=> $merchant_name,
			'image' => $pre_fileName,
			'slug' => $slug,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		if($id!=''){
			Merchant::where('id',$id)->update($input);	
		}else{
			$input['created_at'] = date('Y-m-d H:i:s');
			$id = Merchant::create($input)->id;				
		}	
		echo '|success';				

    }
	
	public function delete_data(Request $request) {

        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Merchant::whereIn('id',$deleteIds)->delete();
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
	
}
