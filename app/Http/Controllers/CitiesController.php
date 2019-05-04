<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Country;
use App\State;
use App\City;
use Mail;

class CitiesController extends Controller
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
		$data['nav'] = 'menu_cities';
		$data['sub_nav'] = 'menu_cities_list';
		$data['title'] = 'Cities';
		$data['sub_title'] = 'List';
		$data['link'] = 'cities-add';
		$results = City::orderBy('id','asc')->get();
		return view('admin.cities.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){

        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = City::select(DB::raw("cities.*, states.name as state_name, countries.name as country_name"))->Join('states',function ($join){$join->on('states.id','=','cities.state_id'); })->Join('countries',function ($join){$join->on('countries.id','=','states.country_id'); });
        if(isset($srch['name']))
        {
            
            $qry->where('cities.name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'cities.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'cities.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'cities.id';
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
		$data['nav'] = 'menu_cities';
		$data['sub_nav'] = 'menu_cities_add';
		$data['title'] = 'City';
		$data['sub_title'] = 'Add';
		$data['link'] = 'cities-list';
		$countries = array();
		$states = array();
		$row = array();
		$result = array();
		$countries = Country::get();
		if($id!=""){
			$result = City::where('id',$id)->first();
			if($result){
				$row = $result;
				$states = State::where('country_id',$row->country_id)->get();
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.cities.add',['row'=>$row,'data'=>$data,'countries'=>$countries, 'states'=>$states]);
    }	
	
	public function save_data(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 
             'country_id' => 'required',			 		 		 		 		 
             'state_id' => 'required',
			 ], 
			$messages = [
			'name.required' => 'Name is required',
			'country_id.required' => 'Country is required',
			'state_id.required' => 'State is required',
		])->validate();	

        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			
			$req   = $request->all();
			$id = $req['id'];

			$input=array(
				'name'=> trim($req['name']),
				'country_id' => $req['country_id'],
				'state_id' => $req['state_id'],
			);
			if($id!=''){
				City::where('id',$id)->update($input);	
			}else{
				$id = City::create($input)->id;				
			}	

			echo "|success";
		
		}
    }
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			City::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
