<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use Mail;



class UsersController extends Controller
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
    public function index(){ 
		$data['nav'] = 'menu_users';
		$data['sub_nav'] = 'menu_users_list';
		$data['title'] = 'Users';
		$data['sub_title'] = 'List';
		$data['link'] = 'users-add';
		$results = User::where('role_id',2)->orderBy('updated_at','desc')->get();
		return view('admin.users.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
       // echo '<pre>';print_r($srch);die;

        $qry = User::select(DB::raw("*"))->where('role_id',2);
			
        if(isset($srch['name'])){
            $qry->where('users.name','like',"%" .$srch['name']. "%");
        }

		if($order[0] == 'list_create'){
			$order[0] = 'users.crated_at';
		}
		else if($order[0] == 'listId'){
			$order[0] = 'users.id';
		}
		else if($order[0] == 'id'){
			$order[0] = 'users.id';
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
	
	
    public function detail($cid){ 
		$data['nav'] = 'menu_users';
		$data['sub_nav'] = 'menu_users_detail';
		$data['title'] = 'User';
		$data['sub_title'] = 'Detail';
		$data['link'] = 'users-list';
		$data['cart_id'] = $cid;
		$results = User::where('role_id',2)->orderBy('updated_at','desc')->get();
		return view('admin.users.detail',['results'=>$results,'data'=>$data]);
    }
	
    public function add($id=""){ 
		$data['nav'] = 'menu_users';
		$data['sub_nav'] = 'menu_users_add';
		$data['title'] = 'User';
		$data['sub_title'] = 'Add';
		$data['link'] = 'users-list';
		$row = array();
		$result = array();
		if($id!=""){
			$result = User::where('id',$id)->where('role_id',2)->orderBy('updated_at','desc')->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.users.add',['row'=>$row,'data'=>$data]);
    }	
	
	public function save_data(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 
             'email' => 'required',			 		 		 
             'email' => 'email',			 		 		 
            // 'address' => 'required',			 		 		 
            // 'phone' => 'required',			 		 		 
			], 
			$messages = [
			'name.required' => 'Name is required',
			'email.required' => 'Email is required',
			'email.email' => 'Email is not valid',
			//'address.required' => 'Address is required',
			//'phone.required' => 'Phone is required',
		])->validate();	

        if (isset($validator) && $validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			$req  = $request->all();
			$id = $req['id'];
			$pre_fileName  = '';
			if(isset($req['file'])){	
				$file=$request->file('file');
				$name=$file->getClientOriginalName();
				$ext=$file->getClientOriginalExtension();
				$pre_fileName= time().rand().'.'.$ext;
				$file->move('user_profile_files',$pre_fileName);

			}elseif($req['file_name'] != ''){
				$pre_fileName = $req['file_name'];
			}
			$input=array(
				'name'=> $req['name'],
				'address' => addslashes($req['address']),
				'email' => $req['email'],
				'phone' => $req['phone'],
				'active' => $req['active'],
				'image' => $pre_fileName,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			if($id!=''){
				User::where('id',$id)->update($input);	
				echo '|success';
			}							
        }
    }
	
	public function delete_data(Request $request) {
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			User::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
}
