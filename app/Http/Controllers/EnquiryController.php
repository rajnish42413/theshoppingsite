<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Enquiry;
use Mail;



class EnquiryController extends Controller
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
		$data['nav'] = 'menu_enquiries';
		$data['sub_nav'] = 'menu_enquiries_list';
		$data['title'] = 'Enquiry';
		$data['sub_title'] = 'List';
		$data['link'] = 'enquiries-add';	
		$results = Enquiry::orderBy('id','asc')->get();
		return view('admin.enquiries.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        //echo '<pre>';print_r($srch);die;

        $qry = Enquiry::select(DB::raw("*"));
		
        if(isset($srch['name']))
        {
            $qry->where('name','like',"%" .$srch['name']. "%");
        }
        
		if($order[0] == 'list_create'){
			$order[0] = 'enquiries.created_at';
		}
		else if($order[0] == 'listId'){
			$order[0] = 'enquiries.id';
		}
		else if($order[0] == 'id'){
			$order[0] = 'enquiries.id';
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
	
	public function delete_data(Request $request) {
        if ($request->isMethod('post')){
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Enquiry::on('mysql2')->whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
