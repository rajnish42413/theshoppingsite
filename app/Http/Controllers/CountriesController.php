<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Country;
use Mail;

class CountriesController extends Controller
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
		$data['nav'] = 'menu_countries';
		$data['sub_nav'] = 'menu_countries_list';
		$data['title'] = 'Countries';
		$data['sub_title'] = 'List';
		$data['link'] = 'countries-add';
		$results = Country::orderBy('id','asc')->get();
		return view('admin.countries.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){

        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = Country::select(DB::raw("*"));
		
        if(isset($srch['name']))
        {
            $qry->where('name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'countries.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'countries.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'countries.id';
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
		$data['nav'] = 'menu_countries';
		$data['sub_nav'] = 'menu_countries_add';
		$data['title'] = 'Country';
		$data['sub_title'] = 'Add';
		$data['link'] = 'countries-list';
		$row = array();
		$result = array();
		if($id!=""){
			$result = Country::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.countries.add',['row'=>$row,'data'=>$data]);
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
				Country::where('id',$id)->update($input);	
			}else{
				$id = Country::create($input)->id;				
			}	

			echo "|success";
		
		}
    }
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Country::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
