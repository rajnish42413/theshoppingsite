<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Currency;
use Mail;

class CurrenciesController extends Controller
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
		$data['nav'] = 'menu_currencies';
		$data['sub_nav'] = 'menu_currencies_list';
		$data['title'] = 'Currency';
		$data['sub_title'] = 'List';
		$data['link'] = 'currencies-add';
		$results = Currency::orderBy('id','asc')->get();
		return view('admin.currencies.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){

        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = Currency::select(DB::raw("*"));
		
        if(isset($srch['name']))
        {
            $qry->where('name','like',"%" .$srch['name']. "%");
        }
        
				if($order[0] == 'list_create'){
					$order[0] = 'currencies.created_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'currencies.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'currencies.id';
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
		$data['nav'] = 'menu_currencies';
		$data['sub_nav'] = 'menu_currencies_add';
		$data['title'] = 'Currency';
		$data['sub_title'] = 'Add';
		$data['link'] = 'currencies-list';
		$row = array();
		$result = array();
		if($id!=""){
			$result = Currency::where('id',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.currencies.add',['row'=>$row,'data'=>$data]);
    }	
	
	public function save_data(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 		 	 		 		 		 
             'exchange_rate' => 'required|numeric|not_in:0',			 	 		 		 		 
			], 
			$messages = [
			'name.required' => 'Currency is required',
			'exchange_rate.required' => 'Exchane Rate is required',
			'exchange_rate.numeric' => 'Exchane Rate must be numeric',
			'exchange_rate.not_in' => 'Exchane Rate must be greater than 0',
		])->validate();	

        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			
			$req   = $request->all();
			$id = $req['id'];
			if(isset($req['status'])){
				$status = 0;
			}else{
				$status = 1;
			}
			$input=array(
				'name'=> trim($req['name']),
				'description' => $req['description'],
				'exchange_rate' => trim($req['exchange_rate']),
				'status' => $status,
			);
			
			if($id!=''){
				Currency::where('id',$id)->update($input);	
			}else{
				$id = Currency::create($input)->id;				
			}	

			echo "|success";
		
		}
    }
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Currency::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
