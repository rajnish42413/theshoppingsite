<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use DB;
use Session;
use App\User;
use App\CurrencyCodes;
use App\Contracts\HotelApiServiceContract;

class UserController extends Controller
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
    public function admin_profile(HotelApiServiceContract $hasc){
		if(Auth::check() && Auth::user()->role_id == 1){
			$data['nav'] = 'menu_admin_profile';
			$data['sub_nav'] = '';
			$data['title'] = 'Admin Profile';
			$data['sub_title'] = '';
			$data['link'] = 'admin-profile';
			$currency_codes = CurrencyCodes::orderBy('id','asc')->get();
			$row = User::where('id',Auth::user()->id)->first();		
			return view('admin.profile',['data'=>$data,'row'=>$row,'currency_codes'=>$currency_codes]);			
		}else{
			return redirect('admin');
		}

    }
	
	public function admin_profile_update(Request $request){
		if ($request->isMethod('post')){
			$req   = $request->all();
			$id = Auth::user()->id;

			$input=array(
				'name'=> $req['name'],
				'email' => trim($req['email']),
				'updated_at' => date('Y-m-d H:i:s'),
			);
			if($id!=''){
				User::on('mysql2')->where('id',$id)->update($input);	
			}	
			echo '|success';				
        }
    }	

	public function admin_change_password(Request $request){
		if ($request->isMethod('post')){
			$req   = $request->all();
			$id = Auth::user()->id;

			$opass= $req['old_password'];
			$npass= $req['password'];
			$cpass= $req['cpassword'];
			$oPassword = Hash::make($opass);
			$user = User::find(auth()->user()->id);
			if(!Hash::check($opass, $user->password)){
				echo 'old_pass_error';
			}else{
				if($npass != $cpass){
					echo 'cpass_no_match';
				}else{
					$nPassword = Hash::make($npass);
					User::on('mysql2')->where('id',Auth::user()->id)->update(array('password'=>$nPassword,'updated_at' => date('Y-m-d H:i:s')));
					echo 'success';
				}
			}	
        }
    }	

	public function admin_image_update(Request $request){
		if ($request->isMethod('post')){
			$req   = $request->all();
			$id = Auth::user()->id;
			$pre_fileName   ='';
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
				'image'=> $pre_fileName,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			if($id!=''){
				User::on('mysql2')->where('id',$id)->update($input);	
			}	
			echo '|success';				
        }
    }
	
}
