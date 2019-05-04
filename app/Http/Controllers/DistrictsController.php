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
use App\District;
use Mail;

class DistrictsController extends Controller
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
		$data['nav'] = 'menu_districts';
		$data['sub_nav'] = 'menu_districts_list';
		$data['title'] = 'Districts';
		$data['sub_title'] = 'List';
		$data['link'] = 'districts-add';
		$results = District::orderBy('id','asc')->get();
		return view('admin.districts.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){

        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = District::select(DB::raw("districts.*, cities.name as city_name, states.name as state_name, countries.name as country_name"))->Join('cities',function ($join){$join->on('cities.id','=','districts.city_id'); })->Join('states',function ($join){$join->on('states.id','=','districts.state_id'); })->Join('countries',function ($join){$join->on('countries.id','=','districts.country_id'); });
        if(isset($srch['name']))
        {
            
            $qry->where('districts.name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'districts.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'districts.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'districts.id';
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
		$data['nav'] = 'menu_districts';
		$data['sub_nav'] = 'menu_districts_add';
		$data['title'] = 'District';
		$data['sub_title'] = 'Add';
		$data['link'] = 'districts-list';
		$countries = array();
		$states = array();
		$cities = array();
		$row = array();
		$result = array();
		$countries = Country::get();
		if($id!=""){
			$result = District::where('id',$id)->first();
			if($result){
				$row = $result;
				$countries = State::where('country_id',$row->country_id)->get();
				$states = State::where('state_id',$row->state_id)->get();
				$cities = City::where('city_id',$row->city_id)->get();
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.districts.add',['row'=>$row,'data'=>$data,'countries'=>$countries, 'states'=>$states,'cities'=>$cities]);
    }	
	
	public function save_data(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 
             'country_id' => 'required',			 		 		 		 		 
             'state_id' => 'required',			 		 		 		 		 
             'city_id' => 'required',			 		 		 		 		 
			], 
			$messages = [
			'name.required' => 'Name is required',
			'country_id.required' => 'Country is required',
			'state_id.required' => 'State is required',
			'city_id.required' => 'City is required',
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
				'city_id' => $req['city_id'],
			);
			if($id!=''){
				District::where('id',$id)->update($input);	
			}else{
				$id = District::create($input)->id;				
			}	

			echo "|success";
		
		}
    }
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			District::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }		
	
}
