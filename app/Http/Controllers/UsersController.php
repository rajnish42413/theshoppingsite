<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\MenuPermission;
use App\Mail\NewUser;
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
		$results = User::where('is_super_admin',0)->orderBy('updated_at','desc')->get();
		return view('admin.users.list',['results'=>$results,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
       // echo '<pre>';print_r($srch);die;

        $qry = User::select(DB::raw("*"))->where('is_super_admin',0);
			
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
		$results = User::where('is_super_admin',0)->orderBy('updated_at','desc')->get();
		return view('admin.users.detail',['results'=>$results,'data'=>$data]);
    }
	
    public function add($id=""){ 
		$data['nav'] = 'menu_users';
		$data['sub_nav'] = 'menu_users_add';
		$data['title'] = 'User';
		$data['sub_title'] = 'Add';
		$data['link'] = 'users-list';
		$menu_permissions = array();
		$menu_permissions = MenuPermission::where('status',1)->orderBy('id','asc')->get();
		$row = array();
		$result = array();
		if($id!=""){
			$result = User::where('id',$id)->orderBy('updated_at','desc')->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.users.add',['row'=>$row,'data'=>$data,'menu_permissions'=>$menu_permissions]);
    }	
	
	public function save_data(Request $request){
		
		$req  = $request->all();
		$id = $req['id'];
		$is_unique = '|unique:users';
 		$user_check = User::where('id',$id)->first();
		
		if($user_check && $user_check->count() > 0){
			if($user_check->email == $req['email']){
				$is_unique = '';
			}
		} 
		
		$validator = $request->validate([
             'name' => 'required|max:100',			 
             'email' => 'required|email|max:100'.$is_unique,			 		 		 
	 	 	], 
			$messages = [
			'name.required' => 'Name is required',
			'email.unique' => 'Email already exists.',
			'email.required' => 'Email is required',
			'email.email' => 'Email is not valid',
		]);

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
		$menu_permissions = array();
		$menu_permissions_value = '';
		$menu_permissions = $req['menu_permissions'];
		if($menu_permissions){
			$menu_permissions_value = implode(',',$menu_permissions);
		}
		$input=array(
			'name'=> $req['name'],
			'email' => $req['email'],
			'is_super_admin' => 0,
			'role_id' => 1,
			'active' => $req['active'],
			'image' => $pre_fileName,
			'menu_permissions' => $menu_permissions_value,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		if($id!=''){
			User::on('mysql2')->where('id',$id)->update($input);	
		}else{
			$random_pass = $this->random_pass();
			$input['verified'] = 1;
			$input['password'] = bcrypt($random_pass);
			$input['created_at'] = date('Y-m-d H:i:s');
			$id = User::on('mysql2')->create($input)->id;	
			$input['password'] = $random_pass;
			Mail::send(new NewUser($input));
		}
		echo '|success';
    }
	
	public function delete_data(Request $request) {
        if ($request->isMethod('post'))
        {
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			User::on('mysql2')->whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }

	public function status_update(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req = $request->all();
			$statusId = $req['id'];
			$status = $req['value'];
			User::on('mysql2')->where('id',$statusId)->update(array('active'=>$status));
			echo 'success';
		}
    }
	
	public function status_multiple_update(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();

			$statusIds = explode(' ,',$req['ids']);
			$status = $req['status'];
			User::on('mysql2')->whereIn('id',$statusIds)->update(array('active'=>$status));
			echo 'success';
		}
    }		
	
	public function random_pass($length = 8){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%";
			return  substr( str_shuffle( $chars ), 0,$length);
	}	
	
}
