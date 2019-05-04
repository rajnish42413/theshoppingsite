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
use Mail;

class StatesController extends Controller
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
		$data['nav'] = 'menu_states';
		$data['sub_nav'] = 'menu_states_list';
		$data['title'] = 'States/Provinces';
		$data['sub_title'] = 'List';
		$data['link'] = 'states-add';
		$results = State::orderBy('id','asc')->get();
		return view('admin.states.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){

        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = State::select(DB::raw("states.*, countries.name as country_name"))->Join('countries',function ($join){$join->on('countries.id','=','states.country_id'); });
        if(isset($srch['name']))
        {
            
            $qry->where('states.name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'states.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'states.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'states.id';
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
		$data['nav'] = 'menu_states';
		$data['sub_nav'] = 'menu_states_add';
		$data['title'] = 'State';
		$data['sub_title'] = 'Add';
		$data['link'] = 'states-list';
		$countries = array();
		$countries = Country::get();
		$row = array();
		$result = array();
		if($id!=""){
			$result = State::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.states.add',['row'=>$row,'data'=>$data,'countries'=>$countries]);
    }	
	
	public function save_data(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 
             'country_id' => 'required',			 		 		 		 		 
			], 
			$messages = [
			'name.required' => 'Name is required',
			'country_id.required' => 'Country is required',
		])->validate();	

        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			
			$req   = $request->all();
			$id = $req['id'];

			$input=array(
				'name'=> $req['name'],
				'country_id' => $req['country_id'],
			);
			if($id!=''){
				State::where('id',$id)->update($input);	
			}else{
				$id = State::create($input)->id;				
			}	

			echo "|success";
		
		}
    }
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			State::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
